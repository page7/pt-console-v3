<?php


// 数据回收站
class retrieve
{
    // 数据库配置
    static $db = null;

    // 数据库表名
    static $table = 'sys_retrieve';

    // 数据库最大长度
    static $maxlength = 1000;

    // 超出最大长度后数据缓存路径
    static $path = '/log/';

    // 备份数据
    static public function backup($rs, $data, $table, $pk='id')
    {
        $db = db::init(self::$db);

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $len = function_exists('mb_strlen') ? mb_strlen($data, 'utf-8') : iconv_strlen($data, 'utf-8');

        if ($len > self::$maxlength)
        {
            $filename = $table . '.' . sha1($data[$pk]);

            $file = self::$path . $filename;

            if (!file_put_contents($file, $data))
            {
                return false;
            }

            $data = 'f:'.$filename;
        }

        $_table = self::$table;

        $rs = $db -> prepare("INSERT INTO `{$_table}` (`table`, `pk`, `data`, `time`) VALUES (:table, :pk, :data, :time)")
                    -> execute(array(':table'=>$table, ':pk'=>$data[$pk], ':data'=>$data, ':time'=>NOW));

        return $rs;
    }


    // 数据还原
    static public function restore($table, $pk, $return = false)
    {
        $db = db::init(self::$db);

        $_table = self::$table;

        $data = $db -> prepare("SELECT * FROM `{$_table}` WHERE `table`=:table AND `pk`=:pk") -> execute(array(':table'=>$table, ':pk'=>$pk));
        if ($data)
        {
            $data = $data[0];

            if (substr($data['data'], 0, 2) == 'f:')
            {
                $_file = substr($data['data'], 2);
            }
        }

        return false;
    }

}
<?php

/**
 * RBAC
 +-----------------------------------------
 * @access public
 * @return void
 */
function rbac()
{
    if (empty($_SESSION['adid']))
    {
        if (!empty($_COOKIE['sess']))
        {
            $s = $_COOKIE['sess'];
            list($uid, $password) = explode('|', cipher(substr($s, 0, -4), substr($s, -4, 4), 'DECODE'));

            $db = \pt\framework\db::init();
            $user = $db -> prepare("SELECT `id`,`name`,`password`,`md`,`role`,`setting` FROM `rbac_user` WHERE `id`=:uid") -> execute(array(':uid'=>$uid));

            if (!$user || $user[0]['password'] != $password || $user[0]['md'] != substr($s, -4, 4))
            {
                setcookie('sess', '', time() - 3600);
                redirect("./login.php?referer=".urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
            }
            else
            {
                $_SESSION['adid']  = $user[0]['id'];
                $_SESSION['name'] = $user[0]['name'];
                $_SESSION['role'] = $user[0]['role'];
            }
        }
        else
        {
            redirect("?module=login&referer=".urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
        }
    }

}



// History
function history($id, $type, $message, $data=null)
{
    if (!$message) return;

    // log histrory
    $data = array(
        'intro'     => pt\tool\string::text($message, 190, '...'),
        'type'      => $type,
        'pk'        => $id,
        'uid'       => (int)$_SESSION['adid'],
        'username'  => (string)$_SESSION['name'],
        'data'      => json_encode($data, JSON_UNESCAPED_UNICODE),
        'time'      => NOW,
    );
    list($column, $sql, $value) = array_values(insert_array($data));

    $db = pt\framework\db::init();
    $rs = $db -> prepare("INSERT INTO `sys_history` {$column} VALUES {$sql};") -> execute($value);
    return $rs;
}




// Delete
function delete($table, $where, $commit=true)
{
    $db = pt\framework\db::init();
    $data = $db -> prepare("SELECT * FROM `{$table}` WHERE {$where};") -> execute();
    if (!$data) return true;

    if ($commit) $db -> beginTrans();

    $log = array(
        ':db'    => $table,
        ':data'  => serialize($data),
        ':time'  => NOW,
    );

    if (!$db -> prepare("INSERT INTO `sys_retrieve` (`db`,`data`,`time`) VALUES (:db, :data, :time);") -> execute($log))
    {
        $db -> rollback();
        return false;
    }

    if (false === $db -> prepare("DELETE FROM `{$table}` WHERE {$where};") -> execute())
    {
        $db -> rollback();
        return false;
    }

    if (!$commit) return true;

    if ($db -> commit()) return true;

    $db -> rollback();
    return false;
}




/**
 * Encode/Decode a string to a ciphertext
 +-----------------------------------------
 * @param string $string
 * @param string $key
 * @param string $operate
 * @param int $expiry
 * @return string
 */
function cipher($string, $key, $operate='ENCODE', $expiry=0)
{
    $ckey_length = 4;

    $key = md5($key);

    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $operate == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length);

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operate == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++)
    {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++)
    {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;

        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++)
    {
        $result .= chr(ord($string[$i]) ^ ($box[$i]));
    }

    if ($operate == 'DECODE')
    {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16))
            return substr($result, 26);
        else
            return '';
    }
    else
    {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}



/**
 * file_get_centents by curl
 +-----------------------------------------
 * @param string $url
 * @param mixed  $post
 * @param int    $timeout
 * @return void
 */
function curl_file_get_contents($url, $post=null, $header=array(), $timeout=5, $proxy=array(), $rqh=false, $rqtype=null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    if ($header)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    if ($proxy)
    {
        curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy['type']);
        curl_setopt($ch, CURLOPT_PROXY, $proxy['server']);
    }

    if ($post)
    {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($post) ? http_build_query($post) : $post);
    }
    if ($rqh)
        curl_setopt($ch, CURLOPT_HEADER, true);

    if (substr($url, 0, 5) == 'https')
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    if ($rqtype)
        curl_setopt($ch, CURLOPT_NOBODY, true);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}




<?php
/* ======================
 * 本实例用于更新所有pt应用，以主文件自动更新所有项目
 */
error_reporting(E_ALL);

// 待更新文件目录
$files = array(
    '/common.php',
    '/common/pt/functions.php',
    '/class/pt/framework/language.class.php'
);


// 主项目
$base = 'D:/www/console/';

// 从项目
$subs = array(
    'be'            => 'D:/www/be/',
    //'jianshen'      => 'D:/www/jianshen/',
    //'latte'         => 'D:/www/latte/',
    //'latte2'        => 'D:/www/latte2/',
    //'weding'        => 'D:/www/weding/',
    //'hzroom'        => 'D:/www/putike_temp/zj/hzroom/',
    //'hangyun'       => 'D:/www/hangyun/',
    'pt'            => 'D:/www/github/pt/',
    'pt-console'    => 'D:/www/github/pt-console/',
    '7yzz'          => 'D:/www/7yzz/',
    'be'            => 'D:/www/be/',
    'pinka'         => 'D:/www/pinka/',
    '66map'         => 'D:/www/66map/'
);

$logfile = './log/syn_err_'.time().'.log';

// 遍历主项目保存文件缓存
$cache = array();
$ftime = array();

foreach ($files as $fi)
{
    $ca = file_get_contents($base . $fi);
    if (!$ca)
    {
        echo $log = "BASEFILE LOAD FAIL:{$fi}.\r\n";
        file_put_contents($logfile, $log, FILE_APPEND);
        continue;
    }

    $cache[$fi] = $ca;
    $ftime[$fi] = filemtime($base . $fi);
}

// 遍历从项目
foreach ($subs as $k => $sub)
{
    // 遍历文件
    foreach ($cache as $fi => $con)
    {
        if (!file_exists(dirname($sub . $fi))) continue;

        $t = filemtime($sub . $fi);
        if ($t >= $ftime[$fi])
        {
            echo $log = "! SKIP: {$k}/{$fi}, NEW {$ftime[$fi]} OLD {$t}.\r\n";
            continue;
        }


        $rs = file_put_contents($sub . $fi, $con);
        if (!$rs)
        {
            echo $log = "× FILE WRITE: {$k}/{$fi} FAIL.\r\n";
            //file_put_contents($logfile, $log, FILE_APPEND);
        }
        else
        {
            echo $log = "√ FILE WRITE: {$k}/{$fi} SUCCESS.\r\n";
        }
    }
}
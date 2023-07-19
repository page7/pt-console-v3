<?php
/* ======================
 * 本实例用于更新所有pt-console应用，以主文件自动更新所有项目
 */
error_reporting(E_ALL);

// 待更新文件目录
$files = array(
//    '/common.php',
//    '/common/pt/functions.php',
    '/class/console.class.php',
    '/class/console/plugin.class.php',
    '/common/console/_page.tpl.php',
    '/common/console/form.tpl.php',
    '/common/console/modal.tpl.php',
    '/common/console/table.tpl.php',
    '/resource/css/console.css',
    '/resource/css/calendar.css',
/*
    '/resource/css/console-login.css',
    '/resource/css/theme.css',
*/
    '/resource/js/console.js',
    '/resource/js/console.zh_CN.js',
    '/resource/js/console.en.js',
    '/resource/js/jquery.pjax.js',
    '/language/en/LC_MESSAGES/console.po',
    '/language/en/LC_MESSAGES/console.mo',
    '/language/zh_CN/LC_MESSAGES/console.po',
    '/language/zh_CN/LC_MESSAGES/console.mo',
);


// 主项目
$base = 'D:/www/console/';

// 从项目
$subs = array(
    'be'            => 'D:/www/be/',
    //'jianshen'      => 'D:/www/jianshen/',
    //'latte'         => 'D:/www/_backup/latte/',
    //'latte2'        => 'D:/www/_backup/latte2/',
    //'weding'        => 'D:/www/weding/',
    '7yzz'          => 'D:/www/7yzz/',
    'pt-console'    => 'D:/www/github/pt-console/',
    //'hzroom'        => 'D:/www/putike_temp/zj/hzroom/',
    //'cosco'         => 'D:/www/_backup/cosco/',
    '66map'         => 'D:/www/66map/',
    'pinka'         => 'D:/www/gitee/pinka/',
    'schoolexpo'    => 'D:/www/gitee/schoolexpo/',
    'schoolsguide'  => 'D:/www/gitee/schoolsguide/',
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
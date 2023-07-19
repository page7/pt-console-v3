<?php
/**
 * Overviews
 +-----------------------------------------
 * @author nolan.chou
 * @category
 * @version $Id$
 */


use pt\framework\template as template;


if (!defined('MODULE')) exit;

function overview()
{
    global $db;

    $today = strtotime('today 00:00:00');

    $start = !empty($_GET['start']) ? strtotime($_GET['start']) : '';
    $end   = !empty($_GET['end']) ? strtotime($_GET['end']) : '';

    if (!$start || !$end)
    {
        $start = $today - 7 * 86400;
        $end = $today;
    }

    $data = array();
    $_data = $db -> prepare("SELECT * FROM `db_analys` WHERE `date` < :end AND `date` >= :start") -> execute(array(':start'=>$start, ':end'=>$end));

    foreach ($_data as $v)
    {
        $date = $v['date'];
        $v['date'] = date('Y-m-d', $v['date']);
        $data[$date] = $v;
    }

    for ($i = $start; $i < $end; $i = $i + 86400)
    {
        $date = date('Y-m-d', $i);
        if (!isset($data[$i]))
        {
            $data[$i] = array("date"=>$date, "user"=>rand(0,100), "uv"=>rand(10,90), "pv"=>rand(10,99));
        }
    }

    template::assign('start', date('Y-m-d', $start));
    template::assign('end', date('Y-m-d', $end));
    template::assign('data', array_values($data));
}




function refresh()
{
    global $db;

    $date = strtotime($_POST['date']);
    if (!$date)
        json_return(null, 1, 'Date is incorrect.');

    // Refresh data, do sth..

    json_return(true);
}
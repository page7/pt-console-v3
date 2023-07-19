<?php
/**
 * project web config
 +-----------------------------------------
 * @author      page7 <zhounan0120@gmail.com>
 * @version     $Id$
 */

return array(
    'build_dir_secure'      => true,       // Auto create index.html in dir
    'time_zone'             => 'PRC',      // Time zone
    'autoload_path'         => '',         // Autoload class path, use "," to set multiple dir
    'ajax_var'              => 'ajax',
    'reflesh_var'           => 'r',
    'i18n'                  => true,

    // init load event's listener
    'listener'              => array(
            'pt\framework\template:display' => array(
                'handler'       => function($tmpl, $debug) {
                    if ($debug)
                            \pt\framework\debug\console::show();
                },
                'priority'      => 10,
                'accepted_args' => 2,
            ),
        ),

    // init load filter
    'filter'                => array(
            'pt\framework\language:debug' => array(
                'handler'       => function($name, $path) {
                    $debug_name = $name . '.debug.'.NOW;
                    return $name;
                },
                'priority'      => 10,
                'accepted_args' => 2,
            ),
        ),

    // copy from pt-console
    'title'             => 'DEMO',
    'title_abbr'        => 'Demo',
    'version'           => 'A1.0',
    'ver'               => 'α1.0',
    'resources_url'     => '/console/resource/',
);


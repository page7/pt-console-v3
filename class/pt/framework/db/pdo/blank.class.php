<?php
/**
 * pdo for empty object
 +-----------------------------------------
 * @category    pt
 * @package     pt\framework\db\pdo
 * @author      page7 <zhounan0120@gmail.com>
 * @version     $Id$
 */

namespace pt\framework\db\pdo;


class blank
{
    public function __construct($config = array()){}

    public function __get($key)
    {
        return '';
    }


    public function __call($method, $args)
    {
        if ($method == 'execute') return null;
        return $this;
    }

}
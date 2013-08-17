<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 06/11/12
 * Time: 16:53
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Lib;

class Singleton
{
    protected static $instance = null;

    protected function __construct()
    {
        //Thou shalt not construct that which is unconstructable!
    }

    protected function __clone()
    {
        //Me not like clones! Me smash clones!
    }

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}
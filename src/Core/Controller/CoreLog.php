<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 28/06/13
 * Time: 22:15
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Controller;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

Trait CoreLog{

    /**
     * @var
     */
    protected $log;

    /**
     *
     */
    public function setLog()
    {
        $this->log = new Logger('app');
        $this->log->pushHandler(new StreamHandler(dirname(__FILE__) . '/../../../log/app.log'));
    }

    /**
     * @return mixed
     */
    public function getLog()
    {
        return $this->log;
    }
}
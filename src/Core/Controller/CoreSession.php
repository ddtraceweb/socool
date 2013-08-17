<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 28/06/13
 * Time: 21:51
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

Trait CoreSession{

    /**
     * @var
     */
    protected $session;

    /**
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public function setSession()
    {
        $storage = new NativeSessionStorage(array(), new PdoSessionHandler($this->getPdo(), [
            'db_table'    => 'session',
            'db_id_col'   => 'session_id',
            'db_data_col' => 'session_value',
            'db_time_col' => 'session_time'
        ]));
        //set session à 2h Max.
        $storage->setOptions(['gc_probability' => 1, 'gc_divisor' => 1, 'gc_maxlifetime' => 600]);
        $this->session = new Session($storage);
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return bool
     */
    public function loadSession()
    {
        return $this->getSession()->start();
    }

    /**
     *
     */
    public function checkSession()
    {
        $maxIdleTime = '600'; //10 minutes

        if (time() - $this->getSession()->getMetadataBag()->getLastUsed() > $maxIdleTime) {
            $this->getSession()->invalidate();
            header('location: ' . $this->generateUrl('index'));
            exit();
        }

        if (!$this->getSession()->has('user')) {
            $this->getSession()->invalidate();
            header('location: ' . $this->generateUrl('index'));
            exit();
        }
    }
}
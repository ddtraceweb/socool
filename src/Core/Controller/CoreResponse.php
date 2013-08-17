<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 10/08/13
 * Time: 11:02
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\Templating\PhpEngine;

Trait CoreResponse{
    /**
     * @var \Symfony\Component\Templating\PhpEngine
     */
    public $view;

    /**
     * @param \Symfony\Component\Templating\PhpEngine $view
     */
    public function setView(PhpEngine $view)
    {
        $this->view = $view;
    }

    /**
     * @param       $name
     * @param array $parameters
     *
     * @return string
     */
    public function render($name, array $parameters = array())
    {

        $arrayMerge               = array();
        $arrayMerge["context"]    = $this->getContext();
        $arrayMerge["request"]    = $this->getRequest();
        $arrayMerge["router"]     = $this->getRouter();
        $arrayMerge["session"]    = $this->getSession();
        $arrayMerge["date"]       = new \DateTime();
        $arrayMerge["translator"] = $this->getTranslator();
        $arrayMerge['seo']        = $this->getSeoArray();

        $parameters = array_merge($arrayMerge, $parameters);
        $this->getView()->set(new SlotsHelper());

        $response = new Response();
        $response->setContent($this->getView()->render($name, $parameters));
        $response->headers->set('Content-Type', 'text/html');
        $response->setCharset('UTF-8');
        return $response;
    }

    /**
     * @return \Symfony\Component\Templating\PhpEngine
     */
    public function getView()
    {
        return $this->view;
    }

    public function renderJson($json)
    {
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
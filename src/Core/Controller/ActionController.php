<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 24/09/12
 * Time: 00:27
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Controller;

use Core\DAO\Repository\Repository;
use Doctrine\Common\Util\Inflector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;


/**
 * Class ActionController
 * @package Core\Controller
 */
class ActionController extends Repository
{
    use CoreSession, CoreLog, CoreTranslator, CoreSeo, CoreResponse;

    /**
     * @var \Symfony\Component\Routing\RequestContext
     */
    public $context;

    /**
     * @var \Symfony\Component\Routing\Router
     */
    public $router;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    public $request;

    /**
     * @var \Symfony\Component\Templating\Loader\FilesystemLoader
     */
    public $loader;

    /**
     * @param \Symfony\Component\Routing\RequestContext $context
     * @param \Symfony\Component\Routing\Router         $router
     */
    public function __construct(RequestContext $context, Router $router)
    {
        \Locale::setDefault('en_US');

        $locale          = \Locale::getDefault();
        $applicationName = Inflector::classify($context->getParameter('application'));

        //set Routing system Environment
        $this->setContext($context);
        $this->setRequest(Request::createFromGlobals());
        $this->setRouter($router);
        $this->setLog();
        $this->setSession();
        $this->loadSession();
        $this->setTranslator($applicationName, $locale);

        $arraySeo = [
            'title'       => 'Socool Project !',
            'description' => 'Socool Description !'
        ];

        $this->setSeoArray($arraySeo);

        if ($this->getContext()->getParameter('security') == 'yes') {
            $this->checkSession();
        }

        //Set Environment Template
        $this->setLoader(new FilesystemLoader(dirname(__FILE__) . '/../../' . $applicationName . '/Views/%name%'));
        $this->setView(new PhpEngine(new TemplateNameParser(), $this->getLoader()));
    }

    /**
     * @param $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return \Symfony\Component\Routing\RequestContext
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * @return \Symfony\Component\Routing\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * {@inheritdoc}
     */
    public function generateUrl($name, $parameters = array(), $absolute = false)
    {
        $this->getContext()->setBaseUrl('');

        return $this->getRouter()->generate($name, $parameters, $absolute);
    }

    /**
     * @param \Symfony\Component\Templating\Loader\FilesystemLoader $loader
     */
    public function setLoader(FilesystemLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @return \Symfony\Component\Templating\Loader\FilesystemLoader
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @param $label
     *
     * @return string
     */
    public function getPost($label)
    {
        return $this->request->request->get($label);
    }

    /**
     * @param $label
     *
     * @return string
     */
    public function getGet($label)
    {
        return $this->request->query->get($label);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}
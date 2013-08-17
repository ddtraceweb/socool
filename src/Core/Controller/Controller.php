<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 23/09/12
 * Time: 23:15
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Controller;

use Doctrine\Common\Util\Inflector;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

/**
 *
 */
class Controller
{
    /**
     * @param \Symfony\Component\Routing\RequestContext $context
     */
    public function __construct(RequestContext $context, Router $router)
    {
            $applicationName = Inflector::classify($context->getParameter('application'));
            $bundleName      = Inflector::classify($context->getParameter('bundle'));
            $controllerName  = Inflector::classify($context->getParameter('controller'));
            $actionName      = Inflector::camelize($context->getParameter('action'));

            $loadController = $applicationName . '\\' . $bundleName . 'Bundle\\Controller\\' . $controllerName . 'Controller';

            $controller = new $loadController($context, $router);
            $nameAction = $actionName . 'Action';

            return $controller->$nameAction();
    }
}
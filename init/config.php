<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 23/09/12
 * Time: 19:57
 * To change this template use File | Settings | File Templates.
 */


use Core\Controller\Controller;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

define('DEBUG', true);

require_once(dirname(__FILE__) . '/../vendor/autoload.php');

try {

    if(DEBUG)
    {
        Debug::enable();
        ErrorHandler::register();
        ExceptionHandler::register();
    }

    $locator = new FileLocator(array(__DIR__));
    $context = new RequestContext($_SERVER['REQUEST_URI']);

    $router = new Router(
        new YamlFileLoader($locator),
        "routes.yml",
        array('cache_dir' => __DIR__ . '/cache', 'debug' => DEBUG),
        $context
    );

    try {
        $context->setParameters($router->match($context->getBaseUrl()));
        $controller = new Controller($context, $router);

    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }

} catch (Exception $e) {

    if ($e->getMessage()) {
        $log = new Logger('app_error');
        $log->pushHandler(new StreamHandler(dirname(__FILE__) . '/../log/app_error.log', Logger::ERROR));
        $log->addError('error_catch_app', array('error' => $e->getMessage()));
    }

    //renvoie une 404
    $response = new Response();
    $response->setContent($e->getMessage());
    $response->setStatusCode(404);
    $response->headers->set('Content-Type', 'text/html');
    $response->send();
}

<?php

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = new \Example\Core\Application();
$route = new \Example\Core\Route\HttpRoute();
$route->add(\Example\Core\Request\HttpRequest::GET, '/', 'Example\Controller\IndexController::read');
$app->setRoute($route);
$app->setRequest(new \Example\Core\Request\HttpRequest());

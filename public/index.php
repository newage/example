<?php

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

if (preg_match('~\/.*\..*$~', $_SERVER['REQUEST_URI'])) {
    return false;
}

$app = new \Example\Core\Application();

$route = new \Example\Core\Route\RestRoute();
$route->rest('/', 'Example\Controller\IndexController');

$app->setRoute($route);
$app->setRequest(new \Example\Core\Request\HttpRequest());
$app->run();

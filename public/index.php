<?php

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

if (preg_match('~\/.*\..*$~', $_SERVER['REQUEST_URI'])) {
    return false;
}

$app = new \Example\Core\Application();

$app->route(null, '/', 'Example\Controller\IndexController');

$app->run();

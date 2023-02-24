<?php

use app\container\Container;
use app\Request;
use app\Router;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$container = Container::getInstance();

$router = $container->get(Router::class);
$request = $container->get(Request::class);

$router->match($request->getServerParams('REQUEST_URI'));
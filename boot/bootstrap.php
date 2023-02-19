<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$router = new \app\Router();
$router->match($_SERVER['REQUEST_URI']);
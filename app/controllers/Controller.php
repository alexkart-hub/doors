<?php

namespace app\controllers;

use app\container\Container;
use app\Request;

abstract class Controller implements iController
{
    public $viewName;
    protected Request $request;
    protected Container $container;

    public function __construct(Request $request, Container $container) {
        $this->request = $request;
        $this->container = $container;
    }

    public function view()
    {
        $content_view = $_SERVER['DOCUMENT_ROOT'] . '/template/views/' . $this->viewName . '.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/template/layout.php';
    }
}
<?php

namespace app\controllers;

abstract class Controller implements iController
{
    public $viewName;

    public function index()
    {
        $this->view();
    }

    public function view()
    {
        $content_view = $_SERVER['DOCUMENT_ROOT'] . '/template/views/' . $this->viewName . '.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/template/layout.php';
    }
}
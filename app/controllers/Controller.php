<?php
namespace app\controllers;

abstract class Controller
{
    public $type = 'start';

    public function view($params)
    {
        $viewFile = $this->type . '.php';
        $content_view = $_SERVER['DOCUMENT_ROOT'].'/template/views/' . $viewFile;
        require $_SERVER['DOCUMENT_ROOT'].'/template/layout.php';
    }
}
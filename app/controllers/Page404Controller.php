<?php

namespace app\controllers;

class Page404Controller implements iController
{
    public function index()
    {
        $content_view = $_SERVER['DOCUMENT_ROOT'].'/template/views/404.php';
        require $_SERVER['DOCUMENT_ROOT'].'/template/layout.php';
    }
}
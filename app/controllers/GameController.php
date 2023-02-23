<?php

namespace app\controllers;

class GameController extends Controller
{

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function load()
    {
        $this->viewName = 'loadGame';
        $this->view();
    }

    public function ajax($fileName = '')
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/ajax/game/' . $fileName . '.php';
        if (!empty($fileName) && file_exists($path)) {
            include_once $path;
        }
        die;
    }
}
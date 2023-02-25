<?php

namespace app\classes;

class Route
{
    public $controller;
    public $action;
    public $params;

    public function __construct($controller, $action = 'index', $params = [])
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
    }
}
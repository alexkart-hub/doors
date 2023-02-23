<?php

namespace app\classes;

class Route
{
    public $url;
    public $controller;
    public $action;
    public $params;

    public function __construct($url, $controller, $action, $params = [])
    {
        $this->url = $url;
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
    }
}
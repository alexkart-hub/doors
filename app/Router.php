<?php

namespace app;

use app\classes\NumberedRoom;
use app\classes\Room404;
use app\classes\Route;
use app\classes\StartRoom;
use app\container\Container;
use app\controllers\GameController;
use app\controllers\Page404Controller;
use app\controllers\RoomController;

class Router
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function match($url)
    {
        $action = 'index';
        $paramsAction = [];
        $urlPath = parse_url($url);
        $query = $urlPath['query'] ?? '';
        if ($urlPath['path'] != '/' && !$this->is_exist($urlPath['path'])) {
            $controller = $this->container->get(Page404Controller::class);
        } elseif ($urlPath['path'] == '/') {
            if (!empty($query)) {
                $arParams = explode('&', $query);
                foreach ($arParams as $paramItem) {
                    $param = explode('=', $paramItem);
                    $params[$param[0]] = $param[1];
                }
                if (isset($params['room']) && is_numeric($params['room']) && ($params['room'] >= 0 && $params['room'] <= 100)) {
                    if ($params['room'] == 0) {
                        $room = $this->container->get(StartRoom::class);
                    } else {
                        $room = $this->container->get(NumberedRoom::class, (int)$params['room']);
                    }
                } else {
                    $room = $this->container->get(Room404::class);
                }
            } else {
                $room = $this->container->get(StartRoom::class);
            }
            $controller = $this->container->get(RoomController::class, $room);
        } else {
            $route = $this->getRoute($urlPath['path']);
            $controller = $this->container->get($route->controller);
            $action = $route->action;
            $paramsAction = $route->params;
        }
        call_user_func_array([$controller, $action], $paramsAction);
    }

    protected function is_exist($url)
    {
        return isset($this->getRoutes()[$url]);
    }

    protected function getRoute($url)
    {
        return $this->getRoutes()[$url];
    }

    protected function getRoutes()
    {
        return [
            '/game/load' => new Route('/game/load', GameController::class, 'load'),
            '/ajax/game/load' => new Route('/ajax/game/load', GameController::class, 'ajax', ['load']),
        ];
    }
}
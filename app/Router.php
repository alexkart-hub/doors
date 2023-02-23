<?php

namespace app;

use app\classes\NumberedRoom;
use app\classes\Room404;
use app\classes\Route;
use app\classes\StartRoom;
use app\controllers\GameController;
use app\controllers\Page404Controller;
use app\controllers\RoomController;

class Router
{
    public function match($url)
    {
        $action = 'index';
        $paramsAction = [];
        $urlPath = parse_url($url);
        $query = $urlPath['query'] ?? '';
        if ($urlPath['path'] != '/' && !$this->is_exist($urlPath['path'])) {
            $controller = new Page404Controller();
        } elseif ($urlPath['path'] == '/') {
            if (!empty($query)) {
                $arParams = explode('&', $query);
                foreach ($arParams as $paramItem) {
                    $param = explode('=', $paramItem);
                    $params[$param[0]] = $param[1];
                }
                if (isset($params['room']) && is_numeric($params['room']) && ($params['room'] >= 0 && $params['room'] <= 100)) {
                    if ($params['room'] == 0) {
                        $room = new StartRoom();
                    } else {
                        $room = new NumberedRoom((int)$params['room']);
                    }
                } else {
                    $room = new Room404();
                }
            } else {
                $room = new StartRoom();
            }
            $controller = new RoomController($room);
        } else {
            $route = $this->getRoute($urlPath['path']);
            $controller = $route->controller;
            $action = $route->action;
            $paramsAction = $route->params;
        }
        call_user_func_array([$controller,$action], $paramsAction);
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
            '/game/load' => new Route('/game/load', new GameController(), 'load'),
            '/ajax/game/load' => new Route('/ajax/game/load', new GameController(), 'ajax', ['load']),
        ];
    }
}
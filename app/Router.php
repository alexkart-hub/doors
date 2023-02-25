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
        $paramsAction = [];
        $urlPath = parse_url($url);
        if ($urlPath['path'] != '/' && !$this->isExist($urlPath['path'])) {
            $controller = $this->container->get(GameController::class);
            $action = 'page404';
        } else {
            $route = $this->getRoute($urlPath['path']);
            $controller = $this->container->get($route->controller);
            $action = $route->action;
            $paramsAction = $route->params;
        }
        call_user_func_array([$controller, $action], $paramsAction);
    }

    protected function isExist($url)
    {
        return isset($this->getRoutesData()[$url]);
    }

    protected function getRoute($url)
    {
        $routeData = $this->getRoutesData()[$url];
        return $this->container->get(Route::class, $routeData);
    }

    /**
     * Данные роута:
     * -Класс контроллера,
     * -Метод контроллера (не обязательно, по-умолчанию index),
     * -Параметры метода контроллера (не обязательно)
     * @return array
     */
    protected function getRoutesData()
    {
        return [
            '/' => [GameController::class],
            '/game/load' => [GameController::class, 'load'],
            '/ajax/game/load' => [GameController::class, 'ajax', ['load']],
        ];
    }
}
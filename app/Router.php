<?php
namespace app;
use app\controllers\RoomController;
use app\controllers\StartController;

class Router
{
    public function match($url)
    {
        $urlPath = parse_url($url);
        $query = $urlPath['query'] ?? '';
        if (!empty($query)) {
            $arParams = explode('&', $query);
            foreach ($arParams as $paramItem) {
                $param = explode('=', $paramItem);
                $params[$param[0]] = $param[1];
            }
            (new RoomController())->index($params);
        } else {
            (new StartController())->index();
        }
    }
}
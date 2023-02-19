<?php
namespace app;
use app\classes\NumberedRoom;
use app\classes\Room404;
use app\classes\StartRoom;
use app\controllers\Page404Controller;
use app\controllers\RoomController;

class Router
{
    public function match($url)
    {
        $urlPath = parse_url($url);
        $query = $urlPath['query'] ?? '';
        if ($urlPath['path'] != '/') {
            $room = new Room404();
        } else {
            if (!empty($query)) {
                $arParams = explode('&', $query);
                foreach ($arParams as $paramItem) {
                    $param = explode('=', $paramItem);
                    $params[$param[0]] = $param[1];
                }
                if (isset($params['room']) && is_numeric($params['room']) && $params['room'] < 100) {
                    $room = new NumberedRoom((int)$params['room']);
                } else {
                    $room = new Room404();
                }
            } else {
                $room = new StartRoom();
            }
        }
        if ($room instanceof Room404) {
            $controller = new Page404Controller();
        } else {
            $controller = new RoomController($room);
        }
        $controller->index();
    }
}
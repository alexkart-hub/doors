<?php

namespace app\controllers;

use app\classes\NumberedRoom;
use app\classes\Room404;
use app\classes\StartRoom;

class GameController extends Controller
{

    public function load()
    {
        $this->viewName = 'loadGame';
        $this->view();
    }

    public function index()
    {
        $params = $this->request->getQueryParams();
        if (!empty($params)) {
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
        $controller = $this->container->get(RoomController::class);
        $controller->index($room);
    }

    public function page404()
    {
        header('http/1.1 404 Not Found');
        $this->viewName = '404';
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
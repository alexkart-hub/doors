<?php

namespace app\controllers;

use app\classes\Room;
use app\classes\StartRoom;

class RoomController extends Controller
{
    public $room;

    public function index(Room $room)
    {
        $this->room = $room;
        $this->view();
    }

    public function view()
    {
        if ($this->room instanceof StartRoom) {
            $fileName = 'start';
        } else {
            $fileName = 'room';
        }
        $content_view = $_SERVER['DOCUMENT_ROOT'] . '/template/views/game.php';
        $page_view = $_SERVER['DOCUMENT_ROOT'] . '/template/views/' . $fileName . '.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/template/layout.php';
    }
}
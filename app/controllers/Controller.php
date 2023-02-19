<?php
namespace app\controllers;

use app\classes\Room;
use app\classes\StartRoom;

abstract class Controller implements iController
{
    public $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function view()
    {
        if ($this->room instanceof StartRoom) {
            $fileName = 'start';
        } else {
            $fileName = 'room';
        }
        $content_view = $_SERVER['DOCUMENT_ROOT'].'/template/views/content.php';
        $page_view = $_SERVER['DOCUMENT_ROOT'].'/template/views/' . $fileName . '.php';
        require $_SERVER['DOCUMENT_ROOT'].'/template/layout.php';
    }
}
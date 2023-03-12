<?php

namespace app\controllers;

use app\classes\Room;
use app\classes\StartRoom;

class RoomController extends Controller
{
    public Room $room;
    public int $roomNumber;
    public int $prevRoomNumber;

    public function index(Room $room)
    {
        $fromUrl = $this->request->getServerParams('HTTP_REFERER');
        $fromUrlData = parse_url($fromUrl);
        if (isset($fromUrlData['query'])) {
            $arQuery = explode('&', $fromUrlData['query']);
            $roomQuery = array_filter($arQuery, function ($item) {
                return preg_match('#^room=#', $item);
            })[0];
            $this->prevRoomNumber = (int)str_replace('room=', '', $roomQuery);
        }
        $this->room = $room;
        $this->roomNumber = $room->getNumber();
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
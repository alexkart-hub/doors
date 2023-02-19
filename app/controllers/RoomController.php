<?php

namespace app\controllers;

class RoomController extends Controller
{
    public function index($params)
    {
        $this->type = 'room';
        $this->view($params);
    }
}
<?php

namespace app\classes;

abstract class Room
{
    protected $number = 0;

    public function getNumber(): int
    {
        return $this->number;
    }
}
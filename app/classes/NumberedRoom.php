<?php

namespace app\classes;

class NumberedRoom extends Room
{
    public function __construct(int $number)
    {
        $this->number = $number;
    }
}
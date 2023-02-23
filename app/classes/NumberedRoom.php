<?php

namespace app\classes;

class NumberedRoom extends Room
{
    public function __construct(int $number)
    {
        $this->number = $number;
        if ($this->number == 3) {
            $this->doubleOut = true;
        }
    }
}
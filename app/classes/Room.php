<?php

namespace app\classes;

abstract class Room
{
    protected $number = 0;
    protected $name;
    public $doubleOut = false;

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setField($fieldName, $value)
    {
        $this->$fieldName = $value;
    }
}
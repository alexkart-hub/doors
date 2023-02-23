<?php

namespace app\classes\tables;

use app\classes\tables\Fields\FieldInt;
use app\classes\tables\Fields\FieldString;

class RoomsTable extends OrmTable
{
    public static function getMap()
    {
        return [
            (new FieldInt('id', 3))->setPrimary(),
            new FieldString('name', 100)
        ];
    }

    public static function getName()
    {
        return 'rooms';
    }
}
<?php

namespace app\classes\tables;

use app\classes\tables\Fields\FieldInt;
use app\classes\tables\Fields\FieldString;

class RoomsTable extends OrmTable
{
    public static function getMap()
    {
        $field = self::$container;
        return [
            $field->get(FieldInt::class, ['id', 3])->setPrimary(),
            $field->get(FieldString::class, ['name', 100]),
        ];
    }

    public static function getName()
    {
        return 'rooms';
    }
}
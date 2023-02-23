<?php

namespace app\classes\tables;

use app\classes\tables\Fields\FieldInt;
use app\classes\tables\Fields\FieldString;

class BoxesTable extends OrmTable
{

    public static function getMap()
    {
        return [
            (new FieldInt('id', 4))->setPrimary(),
            (new FieldInt('type', 2))->setNotNull()->setDefault(1)
        ];
    }

    public static function getName()
    {
        return 'boxes';
    }
}
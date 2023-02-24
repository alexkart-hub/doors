<?php

namespace app\classes\tables;

use app\classes\tables\Fields\FieldInt;

class BoxesTable extends OrmTable
{
    public function getMap()
    {
        $field = $this->container;
        return [
            $field->get(FieldInt::class, ['id', 4])->setPrimary(),
            $field->get(FieldInt::class, ['type', 2])->setNotNull()->setDefault(1),
        ];
    }

    public function getName()
    {
        return 'boxes';
    }
}
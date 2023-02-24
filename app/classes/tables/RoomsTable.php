<?php

namespace app\classes\tables;

use app\classes\NumberedRoom;
use app\classes\StartRoom;
use app\classes\tables\Fields\FieldInt;
use app\classes\tables\Fields\FieldString;

class RoomsTable extends OrmTable
{
    public function getMap()
    {
        $field = $this->container;
        return [
            $field->get(FieldInt::class, ['id', 3])->setPrimary(),
            $field->get(FieldString::class, ['name', 100]),
        ];
    }

    public function getName()
    {
        return 'rooms';
    }

    protected function getObjList(array $arRooms)
    {
        $result = [];
        foreach ($arRooms as $room) {
            if ($room['id'] == 0) {
                $roomObj = $this->container->get(StartRoom::class);
            } else {
                $roomObj = $this->container->get(NumberedRoom::class, $room['id']);
            }
            foreach ($room as $key => $value) {
                if ($key == 'id') {
                    continue;
                }
                $roomObj->setField($key, $value);
            }
            $result[] = $roomObj;
        }
        return $result;
    }
}
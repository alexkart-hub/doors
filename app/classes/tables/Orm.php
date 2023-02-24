<?php

namespace app\classes\tables;

interface Orm
{
    public function getMap();
    public function getName();
    public function add();
    public function delete($id);
    public function getList(array $ids = [], $asArray = false);
    public function getById($id, $asArray = false);
}
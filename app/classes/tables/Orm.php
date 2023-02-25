<?php

namespace app\classes\tables;

interface Orm
{
    public function getMap();
    public function getName();
    public function add(array $params);
    public function update(array $params);
    public function delete($id);
    public function getList(array $ids = [], $asArray = false);
    public function getById($id, $asArray = false);
}
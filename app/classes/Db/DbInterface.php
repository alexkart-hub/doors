<?php

namespace app\classes\Db;

interface DbInterface
{
    public function getName();
    public function getConnection();
    public function query(string $sql, $db = null);
    public function getArray($sql);
}
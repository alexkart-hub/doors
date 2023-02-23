<?php

namespace app\classes\Db;

class DbFactory
{
    public static function get()
    {
        return MysqlDb::getInstance();
    }
}
<?php

namespace app\container;

use app\classes\Db\MysqlDb;

class Instances
{
    public static final function get(): array
    {
        return [
            'queryParams' => $_GET,
            'postParams' => $_POST,
            'serverParams' => $_SERVER,
            MysqlDb::class => MysqlDb::getInstance()
        ];
    }
}
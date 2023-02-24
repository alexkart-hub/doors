<?php

namespace app\classes\Db;

use app\container\Container;

class DbFactory
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get()
    {
        return $this->container->get(MysqlDb::class);
    }
}
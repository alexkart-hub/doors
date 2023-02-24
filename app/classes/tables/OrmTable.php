<?php

namespace app\classes\tables;

use app\classes\Db\DbFactory;
use app\classes\Db\Query\CreateTableQuery;
use app\container\Container;

abstract class OrmTable implements Orm
{
    protected static $db;
    protected static $dbName;
    protected static Container $container;

    public function __construct(Container $container)
    {
        self::$container = $container;
        $db = self::$container->get(DbFactory::class)->get();
        self::$dbName = $db->getName();
        self::$db = $db->getConnection();
        if (!$this->isExistInDb()) {
            $this->createTable();
        }
    }

    public static function createTable()
    {
        $query = self::$container->get(CreateTableQuery::class);
        $sql = $query->setTableName(static::getName())
            ->setFields(static::getMap())
            ->getQuery();
        $result = self::$db->query($sql);
    }

    public static function add()
    {
        // TODO: Implement add() method.
    }

    public static function delete()
    {
        // TODO: Implement delete() method.
    }

    public static function getList()
    {
        // TODO: Implement getList() method.
    }

    public static function getRow()
    {
        // TODO: Implement getRow() method.
    }

    protected function isExistInDb()
    {
        $sql = "SELECT IF(COUNT(*)>0, 'YES', 'NO') AS 'EXIST' FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA`='" . self::$dbName . "' AND `TABLE_NAME`='" . static::getName() . "'";
        $result = self::$db->query($sql)->fetch_row()[0];
        return $result == 'YES';
    }
}
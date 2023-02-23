<?php

namespace app\classes\tables;

use app\classes\Db\DataBase;
use app\classes\Db\DbFactory;
use app\classes\Db\Query\CreateTableQuery;

abstract class OrmTable implements Orm
{
    public static $instance = null;
    protected static $db;
    protected static $dbName;

    private function __construct(DataBase $db)
    {
        self::$dbName = $db->getName();
        self::$db = $db->getConnection();
        if (!$this->isExistInDb()) {
            $this->createTable();
        }
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static(DbFactory::get());
        }
        return static::$instance;
    }

    public static function createTable()
    {
        $query = new CreateTableQuery();
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
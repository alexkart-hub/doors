<?php

namespace app\classes\tables;

use app\classes\Db\DbFactory;
use app\classes\Db\MysqlDb;
use app\classes\Db\Query\CreateTableQuery;
use app\classes\Db\Query\DeleteQuery;
use app\classes\Db\Query\InsertQuery;
use app\classes\Db\Query\SelectQuery;
use app\container\Container;

abstract class OrmTable implements Orm
{
    protected $db;
    protected $connection;
    protected $dbName;
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $db = $this->container->get(DbFactory::class)->get();
        $this->dbName = $db->getName();
        $this->connection = $db->getConnection();
        $this->db = $db;
        if (!$this->isExistInDb()) {
            $this->createTable();
        }
    }

    public function add(array $rows, bool $upsert = false)
    {
        if (empty($rows)) {
            return false;
        }
        if (!is_array($rows[0])) {
            $rows = [$rows];
        }
        /** @var InsertQuery $query */
        $query = $this->container->get(InsertQuery::class);
        $query->table($this->getName());

        $fields = [];
        foreach ($rows as $row) {
            $values = [];
            $addFields = empty($fields);
            foreach ($row as $key => $value) {
                if ($addFields) {
                    $fields[] = $key;
                }
                $values[] = $value;
            }
            if ($addFields) {
                $query->fields($fields);
            }
            $query->values($values);
        }
        if ($upsert) {
            $query->setUpsert();
        }
        $sql = $query->getQuery();
        return $this->db->query($query->getQuery());
    }

    public function update(array $rows)
    {
        return $this->add($rows, true);
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }
        /** @var DeleteQuery $query */
        $query = $this->container->get(DeleteQuery::class);
        $query->table($this->getName())
            ->where('id', $id);
        return $this->db->query($query->getQuery());
    }

    public function getList(array $ids = [], $asArray = false)
    {
        $query = $this->container->get(SelectQuery::class);

        $query->table($this->getName())
            ->where('id', $ids);
        $result = $this->db->getArray($query->getQuery());
        return $asArray ? $result : $this->getObjList($result);
    }

    public function getById($id, $asArray = false)
    {
        return $this->getList([$id], $asArray)[0];
    }

    protected function isExistInDb()
    {
        $sql = "SELECT IF(COUNT(*)>0, 'YES', 'NO') AS 'EXIST' FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA`='" . $this->dbName . "' AND `TABLE_NAME`='" . $this->getName() . "'";
        $result = $this->db->query($sql)->fetch_row()[0];
        return $result == 'YES';
    }

    protected function createTable()
    {
        $query = $this->container->get(CreateTableQuery::class);
        $sql = $query->setTableName(static::getName())
            ->setFields(static::getMap())
            ->getQuery();
        $this->db->query($sql);
    }
}
<?php

namespace app\classes\Db;

class MysqlDb extends DataBase
{
    protected function init()
    {
        $this->type = 'mysql';
    }

    protected function connect()
    {
        $this->db = mysqli_connect($this->host, $this->user, $this->password);

        if (!$this->db) {
            $conn = mysqli_connect($this->host, 'root');
            $this->createUser($conn);
            $this->db = mysqli_connect($this->host, $this->user, $this->password);
        }
    }

    public function createTable($tableName)
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $tableName . '` (
                    `id` int(10) NOT NULL PRIMARY KEY,
                    `value` varchar(100) NOT NULL
                )';
        $result = $this->db->query($sql);
    }

    public function issetDb()
    {
        return $this->db->select_db($this->name);
    }

    public function createDb()
    {
        $sql = 'CREATE DATABASE `' . $this->name . '`';
        return $this->db->query($sql);
    }

    public function createUser($db)
    {
        $sql = "CREATE USER `" . $this->user . "`@`" . $this->host . "` IDENTIFIED BY '" . $this->password . "';";
        $sql .= " GRANT ALL PRIVILEGES ON *.* TO `" . $this->user . "`@`" . $this->host . "` WITH GRANT OPTION;";
        return $db->multi_query($sql);
    }
}
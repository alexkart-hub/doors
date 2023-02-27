<?php

namespace app\classes\Db;

class MysqlDb extends DataBase
{
    public function query(string $sql, $db = null)
    {
        if (!$db) {
            $db = $this->db;
        }
        $sql = trim($sql, ';');
        if (strpos($sql, ';') !== false) {
            return $db->multi_query($sql);
        }
        return $db->query($sql);
    }

    public function getArray($sql)
    {
        $result = $this->query($sql);
        $arRes = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $arRes[] = $row;
            }
        }
        return $arRes;
    }

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
            $conn->close();
            $this->db = mysqli_connect($this->host, $this->user, $this->password);
        }
    }

    protected function issetDb()
    {
        return $this->db->select_db($this->name);
    }

    protected function createDb()
    {
        $sql = 'CREATE DATABASE `' . $this->name . '`';
        return $this->query($sql);
    }

    protected function createUser($db)
    {
        $sql = "CREATE USER `" . $this->user . "`@`" . $this->host . "` IDENTIFIED BY '" . $this->password . "';";
        $sql .= " GRANT ALL PRIVILEGES ON *.* TO `" . $this->user . "`@`" . $this->host . "` WITH GRANT OPTION;";
        return $this->query($sql, $db);
    }
}
<?php

namespace app\classes\Db;

use app\classes\Config;
use \PDO as PDO;

abstract class DataBase
{
    private static $instance = null;
    protected $type;
    protected $db;
    protected $host;
    protected $user;
    protected $password;
    protected $name;

    private function __construct()
    {
        $this->init();
        $connection = Config::getInstance()->get('db.' . $this->type . '.connection');
        foreach ($connection as $key => $value) {
            $this->$key = $value;
        }
        $this->connect();
        if (!$this->issetDb()) {
            $res = $this->createDb();
            if (!$this->issetDb()) {
                throw new \Exception('Не удалось создать базу данных');
            }
        }
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getConnection()
    {
        return $this->db;
    }

    abstract protected function init();

    abstract protected function issetDb();

    abstract protected function createDb();
}
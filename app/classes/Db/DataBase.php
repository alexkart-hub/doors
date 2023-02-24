<?php

namespace app\classes\Db;

use app\classes\Config;
use app\traits\Singleton;

abstract class DataBase
{
    protected $type;
    protected $db;
    protected $host;
    protected $user;
    protected $password;
    protected $name;
    protected $configKeys = [
        'host',
        'user',
        'password',
        'name'
    ];

    use Singleton;

    private function __construct()
    {
        $this->init();
        $this->setConnection();
        if (!$this->issetDb()) {
            $this->createDb();
            if (!$this->issetDb()) {
                throw new \Exception('Не удалось создать базу данных');
            }
        }
    }

    private function __clone()
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function getConnection()
    {
        return $this->db;
    }

    protected function setConnection()
    {
        $config = $this->getConfig();
        foreach ($config as $key => $value) {
            if (in_array($key, $this->configKeys)) {
                $this->$key = $value;
            }
        }
        $this->connect();
    }

    protected function getConfig()
    {
        return Config::getInstance()->get('db.' . $this->type . '.connection');
    }

    abstract protected function init();

    abstract protected function issetDb();

    abstract protected function createDb();
}
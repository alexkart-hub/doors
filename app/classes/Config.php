<?php

namespace app\classes;

class Config
{
    private static $instance = null;
    private $config;

    private function __construct()
    {
        $this->config = require_once $_SERVER['DOCUMENT_ROOT'] . '/boot/config.php';
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $keyString, $config = [])
    {
        if (empty($config)) {
            $config = $this->config;
        }
        $arKey = explode('.', $keyString);
        $result = $config[$arKey[0]];
        if (!empty($arKey[1])) {
           unset($arKey[0]);
           $result = $this->get(implode('.', $arKey), $result);
        }
        return $result;
    }
}
<?php

namespace app\classes\tables;

interface Orm
{
    public static function getMap();
    public static function getName();
    public static function createTable();
    public static function add();
    public static function delete();
    public static function getList();
    public static function getRow();
}
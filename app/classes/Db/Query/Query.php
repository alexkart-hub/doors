<?php

namespace app\classes\Db\Query;

use app\container\Container;

abstract class Query implements SqlData
{
    protected $fields;
    protected $where;
    protected $query;
    protected string $tableName;
    protected $container;
    protected array $error = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getQuery()
    {
        $this->setQuery();
        return $this->query;
    }

    public function getError()
    {
        return $this->error;
    }

    protected function setQuery()
    {
        $this->query = '';
    }

    protected function setParentheses($string)
    {
        return "(" . $string . ")";
    }

    protected function setApostrofQuote($field)
    {
        return "'" . $field . "'";
    }

    protected function setSpace($string)
    {
        return " " . $string . " ";
    }

    protected function setFieldQuote($field)
    {
        return "`" . $field . "`";
    }
}
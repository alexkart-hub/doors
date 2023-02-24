<?php

namespace app\classes\Db\Query;

abstract class Query implements SqlData
{
    protected $fields;
    protected $where;
    protected $query;

    public function getQuery()
    {
        $this->setQuery();
        return $this->query;
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
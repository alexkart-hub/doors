<?php

namespace app\classes\Db\Query;

class SelectQuery extends Query
{
    protected string $sql_start = 'SELECT ';
    protected string $sql_select = ' * ';
    protected string $sql_from;
    protected string $sql_where = '';

    public function select($fields)
    {
        if (!is_array($fields)) {
            $fields = [$fields];
        }
        $arFields = [];
        if (empty($fields) || in_array('*', $fields)) {
            $arFields = ['*'];
            $fields = [];
        }
        foreach ($fields as $alias => $field) {
            $fieldItem = $this->setFieldQuote($field);
            if (!is_numeric($alias)) {
                $fieldItem .= ' AS ' . $this->setApostrofQuote($alias);
            }
            $arFields[] = $fieldItem;
        }
        $this->sql_select = $this->setSpace(implode(',' , $arFields));
        return $this;
    }

    public function table($name)
    {
        $this->sql_from = ' FROM ' . $this->setFieldQuote($name);
        return $this;
    }

    public function where($field, $value, $operation = '=', $logic = 'AND')
    {
        if (empty($value)) {
            return $this;
        }
        if (is_array($value)) {
            $value = array_map([self::class, 'setApostrofQuote'], $value);
            $operation = 'IN';
            $value = $this->setParentheses(implode(',', $value));
        } else {
            $value = is_string($value) ? $this->setApostrofQuote($value) : $value;
        }
        $this->sql_where = empty($this->sql_where) ? $this->setSpace('WHERE') : $this->sql_where . $this->setSpace($logic);
        $this->sql_where .= $this->setFieldQuote($field) . $this->setSpace($operation) . $value;
        return $this;
    }

    protected function setQuery()
    {
        $this->query =
            $this->sql_start .
            $this->sql_select .
            $this->sql_from .
            $this->sql_where;
        return $this;
    }
}
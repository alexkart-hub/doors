<?php

namespace app\classes\Db\Query;

class DeleteQuery extends CRUDQuery
{
    protected string $sql_start = 'DELETE';
    protected string $sql_where = '';

    public function table($name)
    {
        $this->prefix = 'FROM';
        parent::table($name);
        return $this;
    }

    public function where($fieldName, $values, $logic = 'AND')
    {
        if (!is_array($values)) {
            if (!is_int($values)) {
                $values = $this->setApostrofQuote($values);
            }
            $sql_where = $this->setFieldQuote($fieldName) . $this->setSpace('=') . $values;
        } else {
            $sql_where = $this->setFieldQuote($fieldName) . $this->setSpace('IN');
            foreach ($values as &$value) {
                if (!is_int($value)) {
                    $value = $this->setApostrofQuote($value);
                }
            }
            unset($value);
            $sql_where .= $this->setParentheses(implode(',', $values));
        }
        if (empty($this->sql_where)) {
            $this->sql_where = $this->setSpace('WHERE') . $sql_where;
        } else {
            $this->sql_where .= $this->setSpace($logic) . $sql_where;
        }
        return $this;
    }

    protected function setQuery()
    {
        $this->query =
            $this->sql_start .
            $this->sql_table .
            $this->sql_where;
        return $this;
    }
}
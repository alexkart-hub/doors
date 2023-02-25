<?php

namespace app\classes\Db\Query;

class CRUDQuery extends Query
{
    protected string $prefix = '';
    protected string $sql_table = '';

    public function table($name)
    {
        $this->tableName = $name;
        $prefix = !empty($this->prefix) ? $this->setSpace($this->prefix) : '';
        $this->sql_table = $prefix . $this->setFieldQuote($name);
        return $this;
    }
}
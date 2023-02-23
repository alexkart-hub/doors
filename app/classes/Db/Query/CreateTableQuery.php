<?php

namespace app\classes\Db\Query;

use app\classes\tables\Fields\Field;

class CreateTableQuery extends Query
{
    protected string $tableName;
    protected $sql_start;
    protected $sql_end;

    public function __construct()
    {
        $this->sql_start = "CREATE TABLE IF NOT EXISTS ";
    }

    public function setTableName($name)
    {
        $this->tableName = $this->setFieldQuote($name);
        return $this;
    }

    public function setFields(array $fields)
    {
        /** @var Field $field */
        $primaryKey = [];
        foreach ($fields as $field) {
            $type = ' ' . $field->getType();
            $additional = $field->isNotNull() ? ' NOT NULL' : ' NULL';
            $additional .= !empty($field->getDefault()) ? " DEFAULT " . $this->setApostrofQuote($field->getDefault())  : '';
            $sql_fields[] =$this->setFieldQuote($field->getName()) . $type . $additional;
            if ($field->isPrimary()) {
                $primaryKey[] = $this->setFieldQuote($field->getName());
            }
        }
        if (!empty($primaryKey)) {
            $primaryKey = ' PRIMARY KEY ' . $this->setParentheses(implode(',', $primaryKey));
        }
        $this->sql_end = $this->setParentheses(implode(',', array_merge($sql_fields, [$primaryKey]))) . ' ENGINE = InnoDB';
        return $this;
    }

    protected function setQuery()
    {
        $this->query = $this->sql_start . $this->tableName . $this->sql_end;
        return $this;
    }
}
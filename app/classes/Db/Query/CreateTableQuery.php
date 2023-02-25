<?php

namespace app\classes\Db\Query;

use app\classes\tables\Fields\Field;

class CreateTableQuery extends Query
{
    protected $sql_start = "CREATE TABLE IF NOT EXISTS ";
    protected $sql_end;

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
            if ($field->isPrimary()) {
                $additional .= $this->setSpace('AUTO_INCREMENT');
                $primaryKey[] = $this->setFieldQuote($field->getName());
            }
            $sql_fields[] = $this->setFieldQuote($field->getName()) . $type . $additional;
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
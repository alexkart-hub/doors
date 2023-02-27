<?php

namespace app\classes\Db\Query;

use app\classes\tables\Fields\Field;
use app\classes\tables\OrmTable;

class InsertQuery extends CRUDQuery
{
    protected string $sql_start = 'INSERT INTO ';
    protected string $sql_fields = '';
    protected string $sql_values = '';
    protected string $sql_end = '';
    protected array $primaryKey;
    protected array $insertedFields;

    public function setUpsert()
    {
        $insertedFields = $this->insertedFields;
        $sql_end = '';
        $hasPrimary = false;
        foreach ($insertedFields as $field) {
            if (!in_array($field, $this->primaryKey)) {
                $sql_item = $this->setFieldQuote($field) .
                    $this->setSpace('=') .
                    'VALUES' .
                    $this->setParentheses($this->setFieldQuote($field));
                $sql_end .= empty($sql_end) ? $sql_item : ', ' . $sql_item;
            } else {
                $hasPrimary = true;
            }
        }
        if ($hasPrimary) {
            $this->sql_end = $this->setSpace('ON DUPLICATE KEY UPDATE') . $sql_end;
        }
        return $this;
    }

    public function values($values)
    {
        $countValues = count($values);
        $countFields = count($this->insertedFields);
        if ($countValues != $countFields) {
            $this->error[] = 'Поля: ' . implode(',', $this->insertedFields) .
                ', количество полей: ' . $countFields . '; Значения: ' . implode(',', $values) .
                ', количество значений: ' . $countValues;
        }
        $this->sql_values = empty($this->sql_values) ? $this->setSpace('VALUES ') : $this->sql_values . ', ' . PHP_EOL;
        $sql_values = '';
        foreach ($values as $value) {
            $val = is_int($value) ? $value : $this->setApostrofQuote($value);
            $sql_values .= empty($sql_values) ? $val : ', ' . $val;
        }
        $this->sql_values .= $this->setParentheses($sql_values);
        return $this;
    }

    public function fields($fields)
    {
        $this->insertedFields = $fields;
        foreach ($fields as $field) {
            if (!isset($this->fields[$field])) {
                $this->error[] = 'Поля ' . $field . ' нет в таблице ' . $this->tableName;
            }
        }
        $this->sql_fields = $this->setSpace($this->setParentheses($this->setFieldQuote(implode('`,`', $fields))));
        return $this;
    }

    public function table($name)
    {
        parent::table($name);
        $this->primaryKey = $this->getFields();
        return $this;
    }

    protected function getFields()
    {
        $orm = new \ReflectionClass(OrmTable::class);
        $namespace = $orm->getNamespaceName();
        $sd = @scandir($namespace);
        if (!$sd) {
            $path = str_replace('\\', '/', $namespace);
            $sd = scandir($path);
        }
        $files = array_filter($sd, function ($item) {
            return strpos($item, '.php') !== false;
        });
        $arFields = [];
        foreach ($files as $file) {
            $class = $namespace . '\\' . str_replace('.php', '', $file);
            if (class_exists($class) && $class != $orm->getName()) {
                $tableClass = $this->container->get($class);
                if ($tableClass->getName() == $this->tableName) {
                    $arFields = $tableClass->getMap();
                }
            }
        }
        $key = [];
        if (!empty($arFields)) {
            /** @var Field $field */
            foreach ($arFields as $field) {
                $this->fields[$field->getName()] = $field;
                if ($field->isPrimary()) {
                    $key[] = $field->getName();
                }
            }
        }
        return $key;
    }

    protected function setQuery()
    {
        $this->query =
            $this->sql_start .
            $this->sql_table .
            $this->sql_fields .
            $this->sql_values .
            $this->sql_end;
        return $this;
    }
}
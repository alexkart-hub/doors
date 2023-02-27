<?php

namespace test;

use PHPUnit\Framework\TestCase;

abstract class TestBase extends TestCase
{
    /**
     * Переназначаем типы данных (если нужно)
     *
     * @param $type
     * @return mixed|string
     */
    public static function prepareType($type, $goalType = null): mixed
    {
        if ($type == 'NULL' || $type == 'null') {
            $type = $goalType ?? 'string';
        }
        if ($type == 'integer' && !empty($goalType) && ($goalType == 'float' || $goalType == 'double')) {
            // для float, когда приходит без точки
            return $goalType;
        }
        return $type;
    }

    /**
     * Сравниваем типы значений двух массивов
     *
     * @param $struct
     * @param $data
     * @return int|string|void
     */
    public static function getDifferencesValsTypesByArrays($struct, $data, $key = 'root')
    {
        $struct = (array) $struct;
        $data = (array) $data;
        foreach ($struct as $k => $childStruct) {
            if (array_key_exists($k, $data)) {
                if ((is_array($childStruct) || is_object($childStruct)) && !empty((array)$childStruct) && $data[$k] !== null) {
                    $errText = self::getDifferencesValsTypesByArrays($childStruct, $data[$k], $key . '.' . $k);
                } else {
                    $inputType = self::prepareType(gettype($childStruct));
                    $outputType = self::prepareType(gettype($data[$k]), $inputType);
                    if ($inputType != $outputType) {
                        $errText = 'data type invalid';
                    }
                }
            } else {
                $errText = 'response does not contain the field "' . $k . '"';
            }
            if (!empty($errText)) {
                return $key . '.' . $k . ' :: ' . $errText;
            }
        }
        return '';
    }
}
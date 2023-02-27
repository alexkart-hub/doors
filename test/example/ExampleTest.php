<?php

use test\TestBase;

class ExampleTest extends TestBase
{
    public function testOne()
    {
        // образец
        $a = [
            'field1' => 1,
            'field2' => 'text',
            'field3' => [
                'one' => 10,
                'two' => 'string'
            ]
        ];
        // проверяемый массив
        $b = [
            'field1' => 1,
            'field2' => 'text',
            'field3' => [
                'one' => '10',
                'two' => 'string'
            ]
        ];
        $diffType = $this->getDifferencesValsTypesByArrays($a, $b);
        $this->assertEmpty($diffType, $diffType);
    }
}
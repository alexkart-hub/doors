<?php

namespace app\classes\tables\Fields;

class FieldInt extends Field
{
    public function __construct($name, $lenght = 5)
    {
        parent::__construct($name);
        $this->type = "int($lenght)";
    }
}
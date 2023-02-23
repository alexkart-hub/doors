<?php

namespace app\classes\tables\Fields;

class FieldString extends Field
{
    public function __construct(string $name, int $lenght = 255)
    {
        parent::__construct($name);
        $this->type = "varchar($lenght)";
    }

}
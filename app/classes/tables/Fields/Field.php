<?php

namespace app\classes\tables\Fields;

abstract class Field
{
    protected $type;
    protected $name;
    protected $isPrimary = false;
    protected $isNotNull = false;
    protected $default;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setPrimary(): self
    {
        $this->isPrimary = true;
        $this->setNotNull();
        return $this;
    }

    public function setNotNull(): self
    {
        $this->isNotNull = true;
        return $this;
    }

    public function setDefault($value): self
    {
        $this->default = $value;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isPrimary()
    {
        return $this->isPrimary;
    }

    public function isNotNull()
    {
        return $this->isNotNull;
    }

    public function getDefault()
    {
        return $this->default;
    }
}
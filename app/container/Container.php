<?php

namespace app\container;

use app\traits\Singleton;

class Container
{
    private array $instances;

    use Singleton;

    public function __construct()
    {
        $this->instances = Instances::get();
    }

    public function get($element, $params = null)
    {
        if ($this->has($element)) {
            return $this->instances[$element];
        }

        $reflectionClass = new \ReflectionClass($element);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        }


        if (!empty($params)) {
            $constructorParams = is_array($params) ? $params : [$params];
        } else {
            $attributes = $constructor->getParameters();
            $constructorParams = [];
            foreach ($attributes as $attribute) {
                $attributeName = $attribute->getName();
                $attributeType = $attribute->getType();
                if ($attributeType->isBuiltin()) {
                    $constructorParams[] = $this->get($attributeName);
                } else {
                    $attributeClass = $attributeType->getName();
                    $constructorParams[] = $this->get($attributeClass);
                }
            }
        }
        return $reflectionClass->newInstanceArgs($constructorParams);
    }

    private function has($key): bool
    {
        return array_key_exists($key, $this->instances);
    }
}
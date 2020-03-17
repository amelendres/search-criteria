<?php

namespace Appto\User\Application\Definition;

class FilterDefinition
{
    public $name;
    public $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}

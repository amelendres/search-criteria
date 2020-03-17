<?php

namespace Appto\User\Domain\Criteria;

class Order implements SearchCriteria
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function name() : string
    {
        return static::class;
    }

    public function value()
    {
        return $this->fields;
    }
}

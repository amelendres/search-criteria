<?php

namespace Appto\User\Domain\Criteria;

class Order implements Filter
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function name() : string
    {
        return 'order';
    }

    public function value()
    {
        return $this->value();
    }
}

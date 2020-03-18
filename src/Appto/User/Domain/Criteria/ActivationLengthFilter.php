<?php

namespace Appto\User\Domain\Criteria;

use Appto\Common\Domain\Number\NaturalNumber;

class ActivationLengthFilter implements Filter
{
    private $length;

    public function __construct(int $length)
    {
        $this->length = new NaturalNumber($length);
    }

    public function name() : string
    {
        return static::class;
    }

    public function value()
    {
        return $this->length->value();
    }
}

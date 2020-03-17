<?php

namespace Appto\User\Domain\Criteria;

use Appto\Common\Domain\Number\NaturalNumber;

class ActivationLengthFilter implements Filter
{
    private $length;

    public function __construct(NaturalNumber $length)
    {
        $this->length = $length;
    }

    public function name() : string
    {
        return 'activationLength';
    }

    public function value()
    {
        return $this->length->value();
    }
}

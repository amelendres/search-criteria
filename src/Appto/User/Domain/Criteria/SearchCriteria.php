<?php

namespace Appto\User\Domain\Criteria;

interface SearchCriteria
{
    public function name(): string;
    public function value();
}

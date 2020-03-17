<?php

namespace Appto\User\Domain\Criteria;

Interface Filter
{
    public function name(): string;
    public function value();
}

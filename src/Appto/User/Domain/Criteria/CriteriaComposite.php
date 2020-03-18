<?php

namespace Appto\User\Domain\Criteria;

interface CriteriaComposite extends Criteria
{
    public function criteria(string $key): Criteria;

    public function setProviders(array $providers): void;
}

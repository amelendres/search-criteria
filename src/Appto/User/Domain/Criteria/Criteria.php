<?php

namespace Appto\User\Domain\Criteria;

interface Criteria
{
    public function execute(array $feeds): array;
}

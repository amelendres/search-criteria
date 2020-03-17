<?php

namespace Appto\User\Domain\Criteria;

interface Criteria
{
    public function execute(array $feeds): array;
    public function setCriteria($criteria): void;
}

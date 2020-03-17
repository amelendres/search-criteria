<?php

namespace Appto\User\Domain\Criteria;

interface CriteriaComposite
{
    public function add(Criteria $criteria): void;
    public function provider(string $key): string;

    /**
     * @param Criteria[] $criteria
     */
    public function setCriteria(array $criteria): void;

    public function setProviders(array $providers): void;
}

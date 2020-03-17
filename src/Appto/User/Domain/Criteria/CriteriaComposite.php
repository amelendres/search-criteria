<?php

namespace Appto\User\Domain\Criteria;

interface CriteriaComposite
{
    public function add(Criteria $criteria): void;

    /**
     * @param Criteria[] $criteria
     */
    public function setCriteria(array $criteria): void;
}

<?php

namespace Appto\User\Domain\Criteria;

interface CriteriaComposite
{
//    //public function add(Criteria $criteria): void;
//    /**
//     * @param Criteria[] $searchCriteria
//     */
//    public function setSearchCriteria(array $searchCriteria): void;
    public function add(Criteria $criteria): void;
    public function get(string $key): Criteria;
}

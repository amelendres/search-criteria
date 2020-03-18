<?php

namespace Appto\User\Application;

use Appto\User\Application\Definition\SearchCriteriaDefinition;

class FindUsersQuery
{
    private $searchCriteria;

    public function __construct(SearchCriteriaDefinition $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

    public function searchCriteria() : SearchCriteriaDefinition
    {
        return $this->searchCriteria;
    }
}

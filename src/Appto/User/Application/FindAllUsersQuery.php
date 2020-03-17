<?php

namespace Appto\User\Application;

class FindAllUsersQuery
{
    private $searchCriteria;

    public function __construct(array $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

    public function searchCriteria() : array
    {
        return $this->searchCriteria;
    }
}

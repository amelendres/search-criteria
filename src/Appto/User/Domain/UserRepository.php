<?php

namespace Appto\User\Domain;

use Appto\User\Domain\Criteria\Criteria;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function all(): array;

    /**
     * @param Criteria $criteria
     * @return User[]
     */
    public function findByCriteria(Criteria $criteria): array;

}

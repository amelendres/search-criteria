<?php

namespace Appto\User\Domain;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function all(): array;
}

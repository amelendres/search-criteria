<?php

namespace Appto\User\Application;

use Appto\User\Domain\UserRepository;

class FindAllUsersQueryHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(FindAllUsersQuery $query) : array
    {
        return $this->userRepository->all();
    }
}

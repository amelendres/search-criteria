<?php

namespace Appto\User\Application;

use Appto\User\Domain\Criteria\CriteriaComposite;
use Appto\User\Domain\UserRepository;

class FindAllUsersQueryHandler
{
    private $userRepository;
    private $criteriaComposite;

    public function __construct(UserRepository $userRepository, CriteriaComposite $criteria)
    {
        $this->userRepository = $userRepository;
        $this->criteriaComposite = $criteria;
    }

    public function __invoke(FindAllUsersQuery $query) : array
    {
        $this->buildSearchCriteria($query->searchCriteria());

        return $this->userRepository->findByCriteria($this->criteriaComposite);
    }

    private function buildSearchCriteria(array $searchCriteriaDefinition) : void
    {
        foreach ($searchCriteriaDefinition as $name => $value) {
            $searchCriteriaFQNS = sprintf(
                'Appto\User\Infrastructure\Persistence\Csv\Criteria\Csv%sCriteria',
                ucfirst($name)
            );
            $searchCriteria = new $searchCriteriaFQNS();
            $searchCriteria->setCriteria($value);

            $this->criteriaComposite->add($searchCriteria);
        }
    }
}

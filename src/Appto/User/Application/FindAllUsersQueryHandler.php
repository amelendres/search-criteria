<?php

namespace Appto\User\Application;

use Appto\User\Application\Definition\SearchCriteriaDefinition;
use Appto\User\Domain\Criteria\CriteriaComposite;
use Appto\User\Domain\UserRepository;

class FindAllUsersQueryHandler
{
    private $userRepository;
    private $searchCriteriaComposite;

    public function __construct(UserRepository $userRepository, CriteriaComposite $criteria)
    {
        $this->userRepository = $userRepository;
        $this->searchCriteriaComposite = $criteria;
    }

    public function __invoke(FindAllUsersQuery $query) : array
    {
        $this->buildSearchCriteriaComposite($query->searchCriteria());

        return $this->userRepository->findByCriteria($this->searchCriteriaComposite);
    }

    private function buildSearchCriteriaComposite(SearchCriteriaDefinition $searchCriteriaDefinition) : void
    {
        $searchCriteriaParams = $searchCriteriaDefinition->filters;
        $searchCriteriaParams['order'] = $searchCriteriaDefinition->order;

        foreach ($searchCriteriaParams as $name => $value) {
            $searchCriteriaFQNS = sprintf(
                'Appto\User\Infrastructure\Persistence\Csv\Criteria\Csv%sCriteria',
                ucfirst($name)
            );
            //WIP validate input value with VO
            $searchCriteria = new $searchCriteriaFQNS($value);

            $this->searchCriteriaComposite->add($searchCriteria);
        }
    }
}

<?php

namespace Appto\User\Application;

use Appto\User\Application\Definition\SearchCriteriaDefinition;
use Appto\User\Application\Exception\InvalidSearchCriteriaParameterException;
use Appto\User\Domain\Criteria\ActivationLengthFilter;
use Appto\User\Domain\Criteria\CountryFilter;
use Appto\User\Domain\Criteria\CriteriaComposite;
use Appto\User\Domain\Criteria\Order;
use Appto\User\Domain\UserRepository;

class FindUsersQueryHandler
{
    private $userRepository;
    private $searchCriteriaComposite;

    public function __construct(UserRepository $userRepository, CriteriaComposite $criteriaComposite)
    {
        $this->userRepository = $userRepository;
        $this->searchCriteriaComposite = $criteriaComposite;
    }

    public function __invoke(FindUsersQuery $query) : array
    {
        foreach ($this->buildSearchCriteria($query->searchCriteria()) as $searchCriteria) {
            $this->searchCriteriaComposite
                ->criteria($searchCriteria->name())
                ->setValue($searchCriteria->value());
        }

        return $this->userRepository->findByCriteria($this->searchCriteriaComposite);
    }

    private function buildSearchCriteria(SearchCriteriaDefinition $searchCriteriaDefinition) : array
    {
        $searchCriteria = [];
        try {
            $activationLengthFilter = $searchCriteriaDefinition->filter('activationLength');
            if ($activationLengthFilter) {
                $searchCriteria[] = new ActivationLengthFilter($activationLengthFilter->value);
            }

            $countryFilterDefinition = $searchCriteriaDefinition->filter('country');
            if ($countryFilterDefinition) {
                $searchCriteria[] = new CountryFilter($countryFilterDefinition->value);
            }

            $searchCriteria[] = new Order($searchCriteriaDefinition->order);

        } catch (\Exception $exception) {
            throw new InvalidSearchCriteriaParameterException($exception->getMessage());
        }

        return $searchCriteria;
    }
}

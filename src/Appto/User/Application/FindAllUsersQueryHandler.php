<?php

namespace Appto\User\Application;

use Appto\Common\Domain\Number\NaturalNumber;
use Appto\User\Application\Definition\SearchCriteriaDefinition;
use Appto\User\Application\Exception\InvalidSearchCriteriaParameterException;
use Appto\User\Domain\Criteria\ActivationLengthFilter;
use Appto\User\Domain\Criteria\CountryFilter;
use Appto\User\Domain\Criteria\CriteriaComposite;
use Appto\User\Domain\Criteria\Filter;
use Appto\User\Domain\Criteria\Order;
use Appto\User\Domain\Criteria\SearchCriteria;
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
        $this->buildSearchCriteriaComposite($query->searchCriteria());

        return $this->userRepository->findByCriteria($this->criteriaComposite);
    }

    private function buildSearchCriteriaComposite(SearchCriteriaDefinition $searchCriteriaDefinition) : void
    {
        foreach ($this->buildSearchCriteria($searchCriteriaDefinition) as $searchCriteria) {
            $this->addCriteria($searchCriteria);
        }
    }


    private function addCriteria(SearchCriteria $searchCriteria): void
    {
        $providerFQNS = $this->criteriaComposite->provider($searchCriteria->name());
        $criteria = new $providerFQNS($searchCriteria->value());
        $this->criteriaComposite->add($criteria);
    }

    private function buildSearchCriteria(SearchCriteriaDefinition $searchCriteriaDefinition): array
    {
        $searchCriteria = [];
        try {
            $activationLengthFilter = $searchCriteriaDefinition->filter('activationLength');
            if ($activationLengthFilter) {
                $searchCriteria[] = new ActivationLengthFilter(
                    new NaturalNumber($activationLengthFilter->value)
                );
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

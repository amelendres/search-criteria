<?php

namespace Appto\User\Application;

use Appto\Common\Domain\Number\NaturalNumber;
use Appto\User\Application\Definition\SearchCriteriaDefinition;
use Appto\User\Application\Exception\InvalidSearchCriteriaParameterException;
use Appto\User\Domain\Criteria\ActivationLengthFilter;
use Appto\User\Domain\Criteria\CountryFilter;
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
        $criteria = [];
        try {
            $activationLengthFilter = $searchCriteriaDefinition->filter('activationLength');
            if ($activationLengthFilter) {
                $criteria['activationLength'] = new ActivationLengthFilter(
                    new NaturalNumber($activationLengthFilter->value)
                );
            }

            $countryFilterDefinition = $searchCriteriaDefinition->filter('country');
            if ($countryFilterDefinition) {
                $criteria['country'] = new CountryFilter($countryFilterDefinition->value);
            }

            //$criteria['order'] = $searchCriteriaDefinition->order;

        } catch (\Exception $exception) {
            throw new InvalidSearchCriteriaParameterException($exception->getMessage());
        }

        foreach ($criteria as $name => $rule) {
            $providerFQNS = $this->searchCriteriaComposite->provider($name);
            $searchCriteria = new $providerFQNS($rule->value());
            $this->searchCriteriaComposite->add($searchCriteria);
        }

        $providerFQNS = $this->searchCriteriaComposite->provider('order');
        $searchCriteria = new $providerFQNS($searchCriteriaDefinition->order);
        $this->searchCriteriaComposite->add($searchCriteria);

    }
}

<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;

use Appto\User\Domain\Criteria\Criteria;
use Appto\User\Domain\Criteria\CriteriaComposite;

class CsvCriteriaComposite implements CriteriaComposite
{
    private $criteria;
    private $providers;

    public function execute(array $feeds) : array
    {
        /** @var Criteria $rule */
        foreach ($this->criteria as $rule) {
            $feeds = $rule->execute($feeds);
        }

        return $feeds;
    }

    public function setValue($value) : void
    {
        // disabled set criteria
    }

    public function criteria(string $key) : Criteria
    {
        $criteria = $this->find($key);

        if (!$criteria) {
            $criteriaFQNS = $this->provider($key);
            $criteria = new $criteriaFQNS();
            $this->add($criteria);
        }

        return $criteria;
    }

    public function setProviders(array $providers) : void
    {
        array_map(
            function ($key, $providerFQCN) {
                $this->providers[$key] = $providerFQCN;
            },
            array_keys($providers),
            $providers
        );

    }

    private function add(Criteria $criteria) : void
    {
        $this->criteria[get_class($criteria)] = $criteria;
    }

    public function setCriteria($criteria) : void
    {
        array_map(
            function ($criteria) {
                $this->add($criteria);
            },
            $criteria
        );
    }

    private function has(string $key) : bool
    {
        return isset($this->criteria[$key]);
    }

    private function find(string $key) : ?Criteria
    {
        return $this->criteria[$key] ?? null;
    }

    private function provider(string $key) : string
    {
        if (!$this->providers[$key]) {
            throw new UndefinedCriteriaProviderException($key);
        }

        return $this->providers[$key];
    }
}

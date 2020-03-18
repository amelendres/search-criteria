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

    public function add(Criteria $criteria) : void
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

    public function provider(string $key) : string
    {
        if (!$this->has($key)) {
            throw new UndefinedCriteriaProviderException($key);
        }

        return $this->providers[$key];
    }

    private function has(string $key): bool
    {
        return isset($this->providers[$key]);
    }
}

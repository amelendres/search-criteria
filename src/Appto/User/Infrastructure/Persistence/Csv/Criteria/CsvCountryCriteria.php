<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;


use Appto\User\Domain\Criteria\Criteria;

class CsvCountryCriteria implements Criteria
{
    private $countries;

    public function setCriteria($criteria): void
    {
        $this->countries = $criteria;
    }

    public function execute(array $feeds) : array
    {
        $filteredFeeds = array_filter($feeds, function ($item) {
            return in_array($item[4], $this->countries, true);
        });

        return array_values($filteredFeeds);
    }
}

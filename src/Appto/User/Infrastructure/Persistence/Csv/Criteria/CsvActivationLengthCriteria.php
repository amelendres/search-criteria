<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;

use Appto\User\Domain\Criteria\Criteria;

class CsvActivationLengthCriteria implements Criteria
{
    private $activationLength;

    public function __construct(int $length)
    {
        $this->activationLength = $length;
    }

    public function execute(array $feeds): array
    {
        $filteredFeeds = array_filter($feeds, function ($item) {
            $createdDate = new \DateTime($item[5]);
            return $createdDate->diff(new \DateTime($item[6]))->days >= $this->activationLength;
        });

        return array_values($filteredFeeds);
    }
}

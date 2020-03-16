<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;

use Appto\User\Domain\Criteria\Criteria;

class OrderByNameAndLastNameCriteria implements Criteria
{

    public function execute(array $feeds) : array
    {
        usort($feeds, function($feed, $other) {
            return $feed[1] . $feed[2]  <=> $other[1] . $other[2];
        });
        return $feeds;
    }
}

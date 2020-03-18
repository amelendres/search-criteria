<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;

use Appto\User\Domain\Criteria\Criteria;

class CsvOrderCriteria implements Criteria
{
    private $fields;

    public function setValue($fields): void
    {
        $this->fields = $fields;
    }

    public function execute(array $feeds) : array
    {
        usort($feeds, function($feed, $other) {
            //WIP build condition using fields
            return $feed[1] . $feed[2]  <=> $other[1] . $other[2];
        });
        return $feeds;
    }
}

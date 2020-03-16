<?php

namespace Appto\User\Infrastructure\Persistence\Csv;

use Appto\User\Domain\Criteria\Criteria;
use Appto\User\Domain\User;
use Appto\User\Domain\UserRepository;
use Feeder\FeedReader\CsvFeedReader;

class CsvUserRepository implements UserRepository
{
    private $csvReader;
    private $criteria;

    public function __construct(CsvFeedReader $csvReader, Criteria $criteria)
    {
        $this->csvReader = $csvReader;
        $this->criteria = $criteria;
    }

    /**
     * @return User[]
     */
    public function all() : array
    {
        $feeds = $this->csvReader->read();
        $filteredFeeds = $this->criteria->execute($feeds);

        return array_map(
            function ($item) {
                return new User(
                    $item[0],
                    $item[1],
                    $item[2],
                    $item[3],
                    $item[4],
                    $item[5],
                    $item[6],
                    $item[7]
                );
            },
            $filteredFeeds
        );
    }
}

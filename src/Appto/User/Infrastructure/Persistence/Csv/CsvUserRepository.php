<?php

namespace Appto\User\Infrastructure\Persistence\Csv;

use Appto\User\Domain\User;
use Appto\User\Domain\UserRepository;
use Feeder\FeedReader\CsvFeedReader;

class CsvUserRepository implements UserRepository
{
    private $csvReader;

    public function __construct(CsvFeedReader $csvReader)
    {
        $this->csvReader = $csvReader;

    }

    /**
     * @return User[]
     */
    public function all() : array
    {
        $feeds = $this->csvReader->read();

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
            $feeds
        );
    }
}

<?php

namespace Appto\User\Infrastructure\Persistence\Csv;

use Appto\User\Domain\Criteria\Criteria;
use Appto\User\Domain\Filter;
use Appto\User\Domain\User;
use Appto\User\Domain\UserRepository;
use Feeder\FeedReader\CsvFeedReader;

class CsvUserRepository implements UserRepository
{
    private $csvReader;
    private $userAssembler;

    public function __construct(
        CsvFeedReader $csvReader,
        CsvUserAssembler $userAssembler
    ) {
        $this->csvReader = $csvReader;
        $this->userAssembler = $userAssembler;
    }

    /**
     * @return User[]
     */
    public function all() : array
    {
        $feeds = $this->csvReader->read();

        return $this->feedsAssemble($feeds);
    }


    /**
     * @return User[]
     */
    public function findByCriteria(Criteria $criteria) : array
    {
        $feeds = $this->csvReader->read();
        $filteredFeeds = $criteria->execute($feeds);

        return $this->feedsAssemble($filteredFeeds);
    }
    
    private function feedsAssemble(array $feeds): array 
    {
        return array_map(
            function ($item) {
                return $this->userAssembler->assemble($item);
            },
            $feeds
        );
    }


}

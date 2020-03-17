<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;

use Appto\User\Domain\Criteria\Criteria;
use Appto\User\Domain\Criteria\CriteriaComposite;

class CsvCriteriaComposite implements Criteria, CriteriaComposite
{
    private $criteria;

    public function execute(array $feeds) : array
    {
        if(empty($this->criteria)){
            throw new EmptyCriteriaCompositeException();
        }

        /** @var Criteria $rule */
        foreach ($this->criteria as $rule){
            $feeds =  $rule->execute($feeds);
        }

        return $feeds;
    }

    public function add(Criteria $criteria): void
    {
        $this->criteria[get_class($criteria)] = $criteria;
    }

    public function setCriteria($criteria): void
    {
        array_map(function ($criteria){
            $this->add($criteria);
        }, $criteria);
    }
}

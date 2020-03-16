<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;

use Appto\User\Domain\Criteria\Criteria;

class CriteriaComposite implements Criteria
{
    private $criterias;

    public function execute(array $feeds) : array
    {
        if(empty($this->criterias)){
            throw new EmptyCriteriaCompositeException();
        }

        foreach ($this->criterias as $criteria){
            $feeds =  $criteria->execute($feeds);
        }

        return $feeds;
    }

    public function add(Criteria $criteria): void
    {
        $this->criterias[get_class($criteria)] = $criteria;
    }

    public function setCriterias(array $criterias): void
    {
        array_map(function ($criteria){
            $this->add($criteria);
        }, $criterias);
    }

}

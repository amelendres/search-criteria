<?php

namespace Appto\User\Infrastructure\Persistence\Csv\Criteria;

class UndefinedCriteriaProviderException extends \InvalidArgumentException
{
    public function __construct(string $key)
    {
        parent::__construct("Undefined criteria provider <$key>");
    }

}

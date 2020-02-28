<?php

namespace Appto\Booking\Domain\Request\Exception;

class NotFoundDailyPriceException extends \DomainException
{
    public function __construct(\DateTimeInterface $date)
    {
        parent::__construct("Price does not found for <{$date->format('Y-m-d')}>");
    }

}

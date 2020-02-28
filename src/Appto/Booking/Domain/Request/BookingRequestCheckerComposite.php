<?php

namespace Appto\Booking\Domain\Request;


use Appto\Booking\Domain\Request\Exception\EmptyBookingRequestCheckerCompositeException;

class BookingRequestCheckerComposite implements BookingRequestChecker
{
    private $checkers;


    public function check(BookingRequest $bookingRequest): bool
    {
        if(empty($this->checkers)){
            throw new EmptyBookingRequestCheckerCompositeException();
        }

        foreach ($this->checkers as $checker){
            if(!$checker->check($bookingRequest)){
                return false;
            }
        }

        return true;
    }

    public function add(BookingRequestChecker $checker): void
    {
        $this->checkers[get_class($checker)] = $checker;
    }

    public function setCheckers(array $checkers): void
    {
        array_map(function ($checker){
            $this->add($checker);
        }, $checkers);
    }

}

<?php

namespace Appto\Booking\Domain\Request;

interface BookingRequestChecker
{
    public function check(BookingRequest $bookingRequest) : bool;
}

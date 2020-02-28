<?php

namespace Appto\Booking\Domain\Request;


class AvailabilityBookingRequestChecker implements BookingRequestChecker
{
    private $availabilityFinder;

    public function __construct(AvailabilityFinder $availabilityFinder)
    {
        $this->availabilityFinder = $availabilityFinder;
    }

    public function check(BookingRequest $bookingRequest) : bool
    {
        return !empty($this->availabilityFinder->find($bookingRequest));
    }
}

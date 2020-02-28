<?php

namespace Appto\Booking\Domain\Request;


use Appto\Booking\Domain\Availability\Availability;

Interface AvailabilityFinder
{
    /**
     * @return Availability[]
     */
    public function find(BookingRequest $bookingRequest): array;
}

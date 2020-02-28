<?php

namespace Appto\Booking\Domain\Request;


use Appto\Booking\Domain\Boat\BoatRepository;

class CapacityBookingRequestChecker implements BookingRequestChecker
{
    private $boatRepository;

    public function __construct(BoatRepository $boatRepository)
    {
        $this->boatRepository = $boatRepository;
    }

    public function check(BookingRequest $bookingRequest) : bool
    {
        $boat = $this->boatRepository->find($bookingRequest->boatId());
        return $boat
            ? $boat->numberOfPassengers() >= $bookingRequest->numberOfPassengers()
            : false;
    }
}

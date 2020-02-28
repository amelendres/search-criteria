<?php

namespace Appto\Booking\Domain\Boat;

use Appto\Common\Domain\Number\NaturalNumber;

class Boat
{
    private $id;
    private $ownerId;
    private $numberOfPassengers;
    private $length;
    private $bookingCommissionPercent;

    public function __construct(
        BoatId $id,
        OwnerId $ownerId,
        NaturalNumber $numberOfPassengers,
        float $length,
        float $bookingCommissionPercent
    ) {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->numberOfPassengers = $numberOfPassengers;
        $this->length = $length;
        $this->bookingCommissionPercent = $bookingCommissionPercent;
    }

    public function id() : BoatId
    {
        return $this->id;
    }

    public function ownerId() : OwnerId
    {
        return $this->ownerId;
    }

    public function numberOfPassengers() : NaturalNumber
    {
        return $this->numberOfPassengers;
    }

    public function length() : float
    {
        return $this->length;
    }

    public function bookingCommissionPercent() : float
    {
        return $this->bookingCommissionPercent;
    }
}

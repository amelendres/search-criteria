<?php

namespace Appto\Booking\Domain\Request;

use Appto\Common\Domain\DateTime\TimePeriod;
use Appto\Common\Domain\Money\Price;
use Appto\Common\Domain\Number\NaturalNumber;

class BookingRequest
{
    public const DEFAULT_CURRENCY = 'EUR';

    private $id;
    private $boatId;
    private $portId;
    private $numberOfPassengers;
    private $bookingDates;
    private $requester;
    private $comment;
    private $isAvailable;
    private $price;

    public function __construct(
        BookingRequestId $id,
        BoatId $boatId,
        PortId $portId,
        NaturalNumber $numberOfPassengers,
        TimePeriod $bookingDates,
        Requester $requester,
        ?string $comment
    ) {
        $this->id = $id;
        $this->boatId = $boatId;
        $this->portId = $portId;
        $this->requester = $requester;
        $this->bookingDates = $bookingDates;
        $this->numberOfPassengers = $numberOfPassengers;
        $this->comment = $comment;
    }

    public function updatePrice(Price $price) : void
    {
        if ($this->price && $price->equals($this->price)) {
            return;
        }

        $this->price = $price;
    }

    public function makeAvailable() : void
    {
        if (true === $this->isAvailable) {
            return;
        }

        $this->isAvailable = true;
    }

    public function makeUnavailable() : void
    {
        if (false === $this->isAvailable) {
            return;
        }

        $this->isAvailable = false;
    }

    public function id() : BookingRequestId
    {
        return $this->id;
    }

    public function boatId() : BoatId
    {
        return $this->boatId;
    }

    public function portId() : PortId
    {
        return $this->portId;
    }

    public function requester() : Requester
    {
        return $this->requester;
    }

    public function bookingDates() : TimePeriod
    {
        return $this->bookingDates;
    }

    public function numberOfPassengers() : NaturalNumber
    {
        return $this->numberOfPassengers;
    }

    public function comment() : ?string
    {
        return $this->comment;
    }

    public function price() : ?Price
    {
        return $this->price;
    }

    public function isAvailable() : ?bool
    {
        return $this->isAvailable;
    }
}

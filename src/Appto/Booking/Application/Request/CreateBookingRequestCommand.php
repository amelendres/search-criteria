<?php

namespace Appto\Booking\Application\Request;

use Appto\Booking\Application\Request\Definition\RequesterDefinition;

class CreateBookingRequestCommand
{
    private $bookingRequestId;
    private $boatId;
    private $portId;
    private $numberOfPassengers;
    private $startDate;
    private $endDate;
    private $requester;
    private $comment;

    public function __construct(
        string $bookingRequestId,
        string $boatId,
        string $portId,
        int $numberOfPassengers,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        RequesterDefinition $requester,
        ?string $comment
    ) {
        $this->bookingRequestId = $bookingRequestId;
        $this->boatId = $boatId;
        $this->portId = $portId;
        $this->numberOfPassengers = $numberOfPassengers;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->requester = $requester;
        $this->comment = $comment;
    }

    public function bookingRequestId() : string
    {
        return $this->bookingRequestId;
    }

    public function boatId() : string
    {
        return $this->boatId;
    }

    public function portId() : string
    {
        return $this->portId;
    }

    public function numberOfPassengers() : int
    {
        return $this->numberOfPassengers;
    }

    public function startDate() : \DateTimeInterface
    {
        return $this->startDate;
    }

    public function endDate() : \DateTimeInterface
    {
        return $this->endDate;
    }

    public function requester() : RequesterDefinition
    {
        return $this->requester;
    }

    public function comment() : ?string
    {
        return $this->comment;
    }
}

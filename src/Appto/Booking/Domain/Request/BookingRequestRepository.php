<?php

namespace Appto\Booking\Domain\Request;

interface BookingRequestRepository
{
    public function find(string $bookingRequestId): ?BookingRequest;
    public function save(BookingRequest $bookingRequest): void;
}

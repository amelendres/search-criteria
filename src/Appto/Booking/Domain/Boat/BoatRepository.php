<?php

namespace Appto\Booking\Domain\Boat;

interface BoatRepository
{
    public function find(string $boatId): ?Boat;
}

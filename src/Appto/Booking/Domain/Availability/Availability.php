<?php

namespace Appto\Booking\Domain\Availability;

use Appto\Common\Domain\DateTime\TimePeriod;
use Appto\Common\Domain\Money\Price;

class Availability
{
    private $id;
    private $boatId;
    private $portId;
    private $timePeriod;
    private $dailyPrice;

    public function __construct(
        AvailabilityId $id,
        BoatId $boatId,
        PortId $portId,
        TimePeriod $timePeriod,
        Price $dailyPrice
    ) {
        $this->id = $id;
        $this->boatId = $boatId;
        $this->portId = $portId;
        $this->timePeriod = $timePeriod;
        $this->dailyPrice = $dailyPrice;
    }

    public function id() : AvailabilityId
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

    public function timePeriod() : TimePeriod
    {
        return $this->timePeriod;
    }

    public function dailyPrice() : Price
    {
        return $this->dailyPrice;
    }
}

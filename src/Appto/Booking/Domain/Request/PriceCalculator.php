<?php

namespace Appto\Booking\Domain\Request;


use Appto\Common\Domain\Money\Price;

interface PriceCalculator
{
    public function calculate(BookingRequest $bookingRequest) : Price;
}

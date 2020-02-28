<?php

namespace Appto\Booking\Domain\Request;

use Appto\Booking\Domain\Availability\Availability;
use Appto\Booking\Domain\Request\Exception\NotFoundDailyPriceException;
use Appto\Common\Domain\Money\Currency;
use Appto\Common\Domain\Money\Price;


class BookingPriceCalculator implements PriceCalculator
{
    private $availabilityFinder;

    public function __construct(AvailabilityFinder $availabilityFinder)
    {
        $this->availabilityFinder = $availabilityFinder;
    }

    public function calculate(BookingRequest $bookingRequest) : Price
    {
        $availabilities = $this->availabilityFinder->find($bookingRequest);

        $priceAmount = 0;
        /** @var \DateTime $date */
        $date = $bookingRequest->bookingDates()->startDate();
        $endDate = $bookingRequest->bookingDates()->endDate();
        while ($endDate >= $date) {
            $priceAmount += $this->dailyPrice($date, $availabilities)->amount();
            $date->modify('+1 day');
        }

        return new Price($priceAmount, new Currency(Price::DEFAULT_CURRENCY));
    }


    /**
     * @param Availability[] $availabilities
     */
    private function dailyPrice(\DateTimeInterface $date, array $availabilities) : Price
    {
        foreach ($availabilities as $availability) {
            if ($availability->timePeriod()->has($date)) {
                return $availability->dailyPrice();
            }
        }

        throw new NotFoundDailyPriceException($date);
    }

}

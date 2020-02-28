<?php

namespace Test\Unit\Appto\Booking\Domain\Availability\Mother;

use Appto\Booking\Domain\Availability\Availability;
use Appto\Booking\Domain\Availability\AvailabilityId;
use Appto\Booking\Domain\Availability\BoatId;
use Appto\Booking\Domain\Availability\PortId;
use Appto\Booking\Domain\Request\BookingRequest;
use Appto\Common\Domain\DateTime\TimePeriod;
use Appto\Common\Domain\Money\Currency;
use Appto\Common\Domain\Money\Price;
use Test\Unit\Mother;

class AvailabilityMother extends Mother
{

    public static function create(
        string $id,
        string $boatId,
        string $portId,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        string $priceAmount,
        string $priceCurrency
    ) : Availability {
        return new Availability(
            new AvailabilityId($id),
            new BoatId($boatId),
            new PortId($portId),
            new TimePeriod($startDate, $endDate),
            new Price($priceAmount, new Currency($priceCurrency))
        );
    }

    public static function random() : Availability
    {

        return self::create(
            self::faker()->uuid,
            self::faker()->uuid,
            self::faker()->uuid,
            self::faker()->dateTimeInInterval('30 days', '10 days'),
            self::faker()->dateTimeInInterval('41 days', '10 days'),
            self::faker()->randomFloat(),
            self::faker()->currencyCode
        );
    }

    public static function randomForBookingRequest(BookingRequest $bookingRequest, Price $dailyPrice) : Availability
    {

        return self::create(
            self::faker()->uuid,
            $bookingRequest->boatId(),
            $bookingRequest->portId(),
            $bookingRequest->bookingDates()->startDate(),
            $bookingRequest->bookingDates()->endDate(),
            $dailyPrice->amount(),
            $dailyPrice->currency()
        );
    }
}

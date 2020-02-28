<?php

namespace Test\Unit\Appto\Booking\Domain\Request\Mother;

use Appto\Booking\Application\Request\Definition\RequesterDefinition;
use Appto\Booking\Domain\Request\BoatId;
use Appto\Booking\Domain\Request\BookingRequest;
use Appto\Booking\Domain\Request\BookingRequestId;
use Appto\Booking\Domain\Request\PortId;
use Appto\Booking\Domain\Request\Requester;
use Appto\Common\Domain\DateTime\TimePeriod;
use Appto\Common\Domain\Number\NaturalNumber;
use Faker\Factory;

class BookingRequestMother
{
    private static $faker;

    public static function create(
        string $id,
        string $boatId,
        string $portId,
        int $numberOfPassengers,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        RequesterDefinition $requester,
        ?string $comment
    ) : BookingRequest {
        return new BookingRequest(
            new BookingRequestId($id),
            new BoatId($boatId),
            new PortId($portId),
            new NaturalNumber($numberOfPassengers),
            new TimePeriod($startDate, $endDate),
            new Requester(
                $requester->name,
                $requester->email,
                $requester->phoneNumber
            ),
            $comment
        );
    }

    public static function random(): BookingRequest
    {
        self::$faker = Factory::create();

        return self::create(
            self::$faker->uuid,
            self::$faker->uuid,
            self::$faker->uuid,
            self::$faker->numberBetween(5,20),
            self::$faker->dateTimeInInterval( '30 days', '10 days'),
            self::$faker->dateTimeInInterval( '41 days', '10 days'),
            new RequesterDefinition(
                self::$faker->name(),
                self::$faker->email(),
                self::$faker->phoneNumber(),
            ),
            self::$faker->randomElement([null, self::$faker->text()])
        );
    }
}

<?php

namespace Test\Unit\Appto\Booking\Domain\Boat\Mother;

use Appto\Booking\Domain\Boat\Boat;
use Appto\Booking\Domain\Boat\BoatId;
use Appto\Booking\Domain\Boat\OwnerId;
use Appto\Common\Domain\Number\NaturalNumber;
use Test\Unit\Mother;

class BoatMother extends Mother
{

    public static function create(
        string $id,
        string $ownerId,
        int $numberOfPassengers,
        float $length,
        float $bookingCommissionPercent
    ) : Boat {
        return new Boat(
            new BoatId($id),
            new OwnerId($ownerId),
            new NaturalNumber($numberOfPassengers),
            $length,
            $bookingCommissionPercent
        );
    }

    public static function random() : Boat
    {
        return self::create(
            self::faker()->uuid,
            self::faker()->uuid,
            self::faker()->randomNumber(2),
            self::faker()->randomNumber(2),
            self::faker()->randomNumber(2)
        );
    }

    public static function randomWithPassengers(string $id, int $numberOfPassengers ) : Boat
    {
        return self::create(
            $id,
            self::faker()->uuid,
            $numberOfPassengers,
            self::faker()->randomNumber(2),
            self::faker()->randomNumber(2)
        );
    }
}

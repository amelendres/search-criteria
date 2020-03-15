<?php

namespace Test\Unit\Appto\User\Domain\Mother;

use Appto\User\Domain\User;
use Test\Unit\Mother;

class UserMother extends Mother
{
    public static function random(): User
    {
        return new User(
            self::faker()->randomNumber(3),
            self::faker()->word,
            self::faker()->word,
            self::faker()->email,
            self::faker()->countryCode,
            self::faker()->dateTime()->format('d-m-Y'),
            self::faker()->dateTime()->format('d-m-Y'),
            self::faker()->randomNumber(3)
        );
    }

}

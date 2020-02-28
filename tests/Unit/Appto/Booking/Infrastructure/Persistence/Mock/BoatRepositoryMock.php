<?php

namespace Test\Unit\Appto\Booking\Infrastructure\Persistence\Mock;

use Appto\Booking\Domain\Boat\Boat;
use PHPUnit\Framework\TestCase;
use Test\Unit\Mock;

class BoatRepositoryMock extends Mock
{
    public function itShouldFind(string $boatId, Boat $result) : void
    {
        $this->mock()
            ->expects(TestCase::once())
            ->method('find')
            ->with(TestCase::equalTo($boatId))
            ->willReturn($result);
    }
}

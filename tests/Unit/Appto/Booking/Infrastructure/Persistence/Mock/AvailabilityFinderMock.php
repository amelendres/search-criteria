<?php

namespace Test\Unit\Appto\Booking\Infrastructure\Persistence\Mock;

use Appto\Booking\Domain\Request\BookingRequest;
use PHPUnit\Framework\TestCase;
use Test\Unit\Mock;

class AvailabilityFinderMock extends Mock
{

    public function itShouldNotFind(BookingRequest $bookingRequest) : void
    {
        $this->mock()
            ->expects(TestCase::once())
            ->method('find')
            //->with(TestCase::equalTo($bookingRequest))
            ->willReturn([]);
    }

    /**
     * @param Availability[] $result
     */
    public function itShouldFind(BookingRequest $bookingRequest, array $result) : void
    {
        $this->mock()
            //->expects(TestCase::once())
            ->method('find')
            //->with(TestCase::equalTo($bookingRequest))
            ->willReturn($result);
    }
}

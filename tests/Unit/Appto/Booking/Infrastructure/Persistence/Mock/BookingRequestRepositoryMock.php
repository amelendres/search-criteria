<?php

namespace Test\Unit\Appto\Booking\Infrastructure\Persistence\Mock;

use Appto\Booking\Domain\Request\BookingRequest;
use PHPUnit\Framework\TestCase;
use Test\Unit\Mock;

class BookingRequestRepositoryMock extends Mock
{
    public function itShouldSave(BookingRequest $bookingRequest) : void
    {
        $this->mock()
            ->expects(TestCase::once())
            ->method('save')
            ->with(TestCase::equalTo($bookingRequest));
    }
}

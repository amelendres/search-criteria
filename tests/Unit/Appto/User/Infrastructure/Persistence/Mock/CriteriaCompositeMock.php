<?php

namespace Test\Unit\Appto\User\Infrastructure\Persistence\Mock;

use PHPUnit\Framework\TestCase;
use Test\Unit\Mock;

class CriteriaCompositeMock extends Mock
{

    public function itShouldGetOrderAndActivationLengthProvider(string $order, string $activationLength) : void
    {
        $this->mock()
            ->method('provider')
            ->willReturnOnConsecutiveCalls($activationLength, $order);
    }

    public function itShouldGetOrderAndCountryProvider(string $order, string $country) : void
    {
        $this->mock()
            ->method('provider')
            ->willReturnOnConsecutiveCalls($country, $order);
    }

    public function itShouldGetOrderProvider(string $result) : void
    {
        $this->mock()
            ->expects(TestCase::once())
            ->method('provider')
            ->willReturn($result);
    }
}

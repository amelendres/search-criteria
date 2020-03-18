<?php

namespace Test\Unit\Appto\User\Infrastructure\Persistence\Mock;

use Appto\User\Domain\Criteria\Criteria;
use PHPUnit\Framework\TestCase;
use Test\Unit\Mock;

class CriteriaCompositeMock extends Mock
{
    public function itShouldGetOrderAndActivationLengthCriteria(Criteria $order, Criteria $activationLength) : void
    {
        $this->mock()
            ->method('criteria')
            ->willReturnOnConsecutiveCalls($activationLength, $order);
    }

    public function itShouldGetOrderAndCountryCriteria(Criteria $order, Criteria $country) : void
    {
        $this->mock()
            ->method('criteria')
            ->willReturnOnConsecutiveCalls($country, $order);
    }

    public function itShouldGetOrderCriteria(Criteria $result) : void
    {
        $this->mock()
            ->expects(TestCase::once())
            ->method('criteria')
            ->willReturn($result);
    }
}

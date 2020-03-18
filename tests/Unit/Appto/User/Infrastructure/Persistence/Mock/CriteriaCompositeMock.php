<?php

namespace Test\Unit\Appto\User\Infrastructure\Persistence\Mock;

use Appto\User\Domain\Criteria\Criteria;
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

//    public function itShouldGetCountryProvider(string $result) : void
//    {
//        $this->mock()
////            ->expects(TestCase::once())
//            ->method('provider')
//            //->with(TestCase::equalTo($boatId))
//            ->willReturn($result);
//    }

    public function itShouldAddCriteria(Criteria $criteria) : void
    {
        $this->mock()
//            ->expects(TestCase::once())
            ->method('add')
            ->with(TestCase::equalTo($criteria))
            //->willReturn($result)
            ;
    }
}

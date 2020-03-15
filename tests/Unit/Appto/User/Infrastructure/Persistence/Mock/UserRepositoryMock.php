<?php

namespace Test\Unit\Appto\User\Infrastructure\Persistence\Mock;

use Appto\User\Domain\User;
use PHPUnit\Framework\TestCase;
use Test\Unit\Mock;

class UserRepositoryMock extends Mock
{
    /**
     * @param User[] $result
     */
    public function itShouldFindAll(array $result) : void
    {
        $this->mock()
            ->expects(TestCase::once())
            ->method('all')
            //->with(TestCase::equalTo($boatId))
            ->willReturn($result);
    }

    /**
     * @param array $result
     */
    public function itShouldNotFind(array $result = []) : void
    {
        $this->mock()
            ->expects(TestCase::once())
            ->method('all')
            //->with(TestCase::equalTo($boatId))
            ->willReturn($result);
    }
}

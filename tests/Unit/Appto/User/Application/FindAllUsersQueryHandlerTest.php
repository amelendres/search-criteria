<?php

namespace Test\Unit\Appto\User\Application;

use Appto\User\Application\FindAllUsersQuery;
use Appto\User\Application\FindAllUsersQueryHandler;
use Appto\User\Domain\UserRepository;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Test\Unit\Appto\User\Domain\Mother\UserMother;
use Test\Unit\Appto\User\Infrastructure\Persistence\Mock\UserRepositoryMock;

class FindAllUsersQueryHandlerTest extends TestCase
{
    private $handler;

    /** @var UserRepositoryMock */
    private $userRepository;
    private $faker;


    protected function setUp() : void
    {
        $this->userRepository = $this->userRepository ?? new UserRepositoryMock(
                $this->getMockBuilder(UserRepository::class)
            );

        $this->handler = $this->handler ?? new FindAllUsersQueryHandler(
                $this->userRepository->mock()
            );

        $this->faker = Factory::create();
        parent::setUp();
    }

    /**
     * @group all
     */
    public function testItShouldFindAllUsers()
    {
        $command = new FindAllUsersQuery();
        $users = [
            UserMother::random(),
            UserMother::random(),
            UserMother::random(),
        ];

        $this->userRepository->itShouldFindAll($users);

        $result = $this->handle($command);

        self::assertNotEmpty($result);

    }

    /**
     * @group all
     */
    public function testItShouldNotFind()
    {
        $command = new FindAllUsersQuery();
        $users = [];

        $this->userRepository->itShouldNotFind($users);

        $result = $this->handle($command);

        self::assertEmpty($result);

    }

    /**
     * @group all
     */
//    public function testItShouldFailFindWithoutResource()
//    {
//        $command = new FindAllUsersQuery();
//        $users = [];
//
//        $this->userRepository->itShouldNotFind($users);
//
//        $result = $this->handle($command);
//
//        self::assertEmpty($result);
//
//    }


    private function handle($command) : array
    {
        return ($this->handler)($command);
    }
}

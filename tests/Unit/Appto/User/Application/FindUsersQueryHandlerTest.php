<?php

namespace Test\Unit\Appto\User\Application;

use Appto\User\Application\Definition\FilterDefinition;
use Appto\User\Application\Definition\SearchCriteriaDefinition;
use Appto\User\Application\Exception\InvalidSearchCriteriaParameterException;
use Appto\User\Application\FindUsersQuery;
use Appto\User\Application\FindUsersQueryHandler;
use Appto\User\Domain\Criteria\CriteriaComposite;
use Appto\User\Domain\UserRepository;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Test\Unit\Appto\User\Domain\Mother\UserMother;
use Test\Unit\Appto\User\Infrastructure\Persistence\Mock\CriteriaCompositeMock;
use Test\Unit\Appto\User\Infrastructure\Persistence\Mock\UserRepositoryMock;


class FindUsersQueryHandlerTest extends TestCase
{
    private $handler;

    /** @var UserRepositoryMock */
    private $userRepository;
    private $searchCriteria;
    private $faker;


    protected function setUp() : void
    {
        $this->userRepository = $this->userRepository ?? new UserRepositoryMock(
                $this->getMockBuilder(UserRepository::class)
            );
        $this->searchCriteria = $this->searchCriteria ?? new CriteriaCompositeMock(
                $this->getMockBuilder(CriteriaComposite::class)
            );

        $this->handler = $this->handler ?? new FindUsersQueryHandler(
                $this->userRepository->mock(),
                $this->searchCriteria->mock()
            );

        $this->faker = Factory::create();
        parent::setUp();
    }

    public function testItShouldFindAllUsers()
    {
        $order = [];
        $command = new FindUsersQuery(new SearchCriteriaDefinition([], $order));

        $users = [
            UserMother::random(),
            UserMother::random(),
            UserMother::random(),
        ];

        $this->userRepository->itShouldFind($users);

        $result = $this->handle($command);

        self::assertNotEmpty($result);

    }

    public function testItShouldNotFind()
    {
        $command = new FindUsersQuery(new SearchCriteriaDefinition([], []));
        $users = [];

        $this->userRepository->itShouldNotFind($users);

        $result = $this->handle($command);

        self::assertEmpty($result);
    }

    public function testItShouldFindWithCountryFilter()
    {
        $order = [];
        $countries = [
            $this->faker->unique()->countryCode,
            $this->faker->unique()->countryCode,
        ];
        $countryFilterDefinition = new FilterDefinition('country', $countries);
        $command = new FindUsersQuery(
            new SearchCriteriaDefinition([$countryFilterDefinition], $order)
        );
        $users = [
            UserMother::random(),
            UserMother::random(),
            UserMother::random(),
        ];

        $this->userRepository->itShouldFind($users);

        $result = $this->handle($command);

        self::assertNotEmpty($result);
    }

    public function testItShouldFailWithInvalidCountry()
    {
        $this->expectException(InvalidSearchCriteriaParameterException::class);
        $order = [];
        $countries = ['USa'];
        $countryFilterDefinition = new FilterDefinition('country', $countries);
        $command = new FindUsersQuery(
            new SearchCriteriaDefinition([$countryFilterDefinition], $order)
        );
        $users = [];

        $result = $this->handle($command);

        self::assertNotEmpty($result);
    }

    /**
     * @group test
     */
    public function testItShouldFindWithActivationLengthFilter()
    {
        $order = [];
        $activationLength = $this->faker->numberBetween(1, 30);
        $activationLengthFilterDefinition = new FilterDefinition('activationLength', $activationLength);

        $command = new FindUsersQuery(
            new SearchCriteriaDefinition([$activationLengthFilterDefinition], $order)
        );
        $users = [
            UserMother::random(),
            UserMother::random(),
            UserMother::random(),
        ];

        $this->userRepository->itShouldFind($users);

        $result = $this->handle($command);

        self::assertNotEmpty($result);
    }

    private function handle($command) : array
    {
        return ($this->handler)($command);
    }
}

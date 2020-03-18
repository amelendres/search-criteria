<?php

namespace Test\Unit\Appto\User\Application;

use Appto\User\Application\Definition\FilterDefinition;
use Appto\User\Application\Definition\SearchCriteriaDefinition;
use Appto\User\Application\Exception\InvalidSearchCriteriaParameterException;
use Appto\User\Application\FindAllUsersQuery;
use Appto\User\Application\FindAllUsersQueryHandler;
use Appto\User\Domain\Criteria\CriteriaComposite;
use Appto\User\Domain\UserRepository;
use Appto\User\Infrastructure\Persistence\Csv\Criteria\CsvActivationLengthCriteria;
use Appto\User\Infrastructure\Persistence\Csv\Criteria\CsvCountryCriteria;
use Appto\User\Infrastructure\Persistence\Csv\Criteria\CsvOrderCriteria;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Test\Unit\Appto\User\Domain\Mother\UserMother;
use Test\Unit\Appto\User\Infrastructure\Persistence\Mock\CriteriaCompositeMock;
use Test\Unit\Appto\User\Infrastructure\Persistence\Mock\UserRepositoryMock;


class FindAllUsersQueryHandlerTest extends TestCase
{
    private $handler;

    /** @var UserRepositoryMock */
    private $userRepository;
    private $criteriaComposite;
    private $faker;


    protected function setUp() : void
    {
        $this->userRepository = $this->userRepository ?? new UserRepositoryMock(
                $this->getMockBuilder(UserRepository::class)
            );
        $this->criteriaComposite = $this->criteriaComposite ?? new CriteriaCompositeMock(
                $this->getMockBuilder(CriteriaComposite::class)
            );

        $this->handler = $this->handler ?? new FindAllUsersQueryHandler(
                $this->userRepository->mock(),
                $this->criteriaComposite->mock()
            );

        $this->faker = Factory::create();
        parent::setUp();
    }

    public function testItShouldFindAllUsers()
    {
        $order = [];
        $command = new FindAllUsersQuery(
            new SearchCriteriaDefinition([], $order)
        );
        $users = [
            UserMother::random(),
            UserMother::random(),
            UserMother::random(),
        ];

        $this->userRepository->itShouldFindAll($users);
        $this->criteriaComposite->itShouldGetOrderProvider(CsvOrderCriteria::class);

        $result = $this->handle($command);

        self::assertNotEmpty($result);

    }

    public function testItShouldNotFind()
    {
        $command = new FindAllUsersQuery(
            new SearchCriteriaDefinition([], [])
        );
        $users = [];

        $this->userRepository->itShouldNotFind($users);
        $this->criteriaComposite->itShouldGetOrderProvider(CsvOrderCriteria::class);

        $result = $this->handle($command);

        self::assertEmpty($result);

    }

    /**
     * @group test
     */
    public function testItShouldFindWithCountryFilter()
    {
        $order = [];
        $countries= [
            $this->faker->unique()->countryCode,
            $this->faker->unique()->countryCode,
        ];
        $countryFilterDefinition = new FilterDefinition('country', $countries);
        $command = new FindAllUsersQuery(
            new SearchCriteriaDefinition([$countryFilterDefinition], $order)
        );
        $users = [
            UserMother::random(),
            UserMother::random(),
            UserMother::random(),
        ];

        $this->userRepository->itShouldFindAll($users);
        $this->criteriaComposite->itShouldGetOrderAndCountryProvider(CsvOrderCriteria::class, CsvCountryCriteria::class);

        $result = $this->handle($command);

        self::assertNotEmpty($result);
    }

    /**
     * @group test
     */
    public function testItShouldFailWithInvalidCountry()
    {
        $this->expectException(InvalidSearchCriteriaParameterException::class);
        $order = [];
        $countries= ['USa'];
        $countryFilterDefinition = new FilterDefinition('country', $countries);
        $command = new FindAllUsersQuery(
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
        $activationLength = $this->faker->numberBetween(1,30);
        $activationLengthFilterDefinition = new FilterDefinition('activationLength', $activationLength);

        $command = new FindAllUsersQuery(
            new SearchCriteriaDefinition([$activationLengthFilterDefinition], $order)
        );
        $users = [
            UserMother::random(),
            UserMother::random(),
            UserMother::random(),
        ];

        $this->userRepository->itShouldFindAll($users);
        $this->criteriaComposite->itShouldGetOrderAndActivationLengthProvider(
            CsvOrderCriteria::class,
            CsvActivationLengthCriteria::class
        );

        $result = $this->handle($command);

        self::assertNotEmpty($result);
    }

    private function handle($command) : array
    {
        return ($this->handler)($command);
    }
}

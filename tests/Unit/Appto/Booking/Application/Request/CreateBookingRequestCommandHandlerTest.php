<?php

namespace Test\Unit\Appto\Booking\Application\Request;

use Appto\Booking\Application\Request\CreateBookingRequestCommand;
use Appto\Booking\Application\Request\Definition\RequesterDefinition;
use Appto\Booking\Domain\Boat\BoatRepository;
use Appto\Booking\Domain\Request\AvailabilityBookingRequestChecker;
use Appto\Booking\Domain\Request\AvailabilityFinder;
use Appto\Booking\Domain\Request\BookingPriceCalculator;
use Appto\Booking\Domain\Request\BookingRequestCheckerComposite;
use Appto\Booking\Domain\Request\BookingRequestRepository;
use Appto\Booking\Domain\Request\CapacityBookingRequestChecker;
use Appto\Common\Domain\Money\Currency;
use Appto\Common\Domain\Money\Price;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Appto\Booking\Application\Request\CreateBookingRequestCommandHandler;
use Test\Unit\Appto\Booking\Domain\Availability\Mother\AvailabilityMother;
use Test\Unit\Appto\Booking\Domain\Boat\Mother\BoatMother;
use Test\Unit\Appto\Booking\Domain\Request\Mother\BookingRequestMother;
use Test\Unit\Appto\Booking\Infrastructure\Persistence\Mock\AvailabilityFinderMock;
use Test\Unit\Appto\Booking\Infrastructure\Persistence\Mock\BoatRepositoryMock;
use Test\Unit\Appto\Booking\Infrastructure\Persistence\Mock\BookingRequestRepositoryMock;

class CreateBookingRequestCommandHandlerTest extends TestCase
{
    private $handler;

    /** @var BookingRequestRepositoryMock */
    private $bookingRequestRepository;

    /** @var AvailabilityFinderMock */
    private $availabilityFinder;

    /** @var BoatRepositoryMock */
    private $boatRepository;

    private $faker;

    protected function setUp() : void
    {
        $this->bookingRequestRepository = $this->bookingRequestRepository ?? new BookingRequestRepositoryMock(
                $this->getMockBuilder(BookingRequestRepository::class)
            );

        $this->availabilityFinder = $this->availabilityFinder ?? new AvailabilityFinderMock(
                $this->getMockBuilder(AvailabilityFinder::class)
            );
        $this->boatRepository = $this->boatRepository ?? new BoatRepositoryMock(
                $this->getMockBuilder(BoatRepository::class)
            );

        $bookingRequestChecker = new BookingRequestCheckerComposite();
        $bookingRequestChecker->add(
            new AvailabilityBookingRequestChecker($this->availabilityFinder->mock())
        );
        $bookingRequestChecker->add(
            new CapacityBookingRequestChecker($this->boatRepository->mock())
        );
        $this->handler = $this->handler ?? new CreateBookingRequestCommandHandler(
                $this->bookingRequestRepository->mock(),
                $bookingRequestChecker,
                new BookingPriceCalculator($this->availabilityFinder->mock())
            );

        $this->faker = Factory::create();
        parent::setUp();
    }

    /**
     * @group unavailable
     */
    public function testItShouldCreateBookingRequestUnavailable()
    {
        $bookingRequest = BookingRequestMother::random();
        $bookingRequest->makeUnavailable();

        $command = new CreateBookingRequestCommand(
            $bookingRequest->id(),
            $bookingRequest->boatId(),
            $bookingRequest->portId(),
            $bookingRequest->numberOfPassengers()->value(),
            $bookingRequest->bookingDates()->startDate(),
            $bookingRequest->bookingDates()->endDate(),
            new RequesterDefinition(
                $bookingRequest->requester()->name(),
                $bookingRequest->requester()->email(),
                $bookingRequest->requester()->phoneNumber()
            ),
            $bookingRequest->comment()
        );

        $this->availabilityFinder->itShouldNotFind($bookingRequest);
        $this->bookingRequestRepository->itShouldSave($bookingRequest);

        ($this->handler)($command);

        $this->assertFalse($bookingRequest->isAvailable());
        $this->assertNull($bookingRequest->price());
    }

    /**
     * @group available
     */
    public function testItShouldCreateBookingRequestAvailableWithPrice()
    {
        $bookingRequest = BookingRequestMother::random();
        $boat = BoatMother::randomWithPassengers(
            $bookingRequest->id(),
            $bookingRequest->numberOfPassengers()->value()
        );

        $dailyPrice = new Price(100, new Currency('EUR'));
        $bookingPrice = new Price(
            $bookingRequest->bookingDates()->days() * $dailyPrice->amount(),
            new Currency('EUR')
        );
        $availabilities = [
            AvailabilityMother::randomForBookingRequest($bookingRequest, $dailyPrice)
        ];

        $bookingRequest->makeAvailable();
        $bookingRequest->updatePrice($bookingPrice);

        $command = new CreateBookingRequestCommand(
            $bookingRequest->id(),
            $bookingRequest->boatId(),
            $bookingRequest->portId(),
            $bookingRequest->numberOfPassengers()->value(),
            $bookingRequest->bookingDates()->startDate(),
            $bookingRequest->bookingDates()->endDate(),
            new RequesterDefinition(
                $bookingRequest->requester()->name(),
                $bookingRequest->requester()->email(),
                $bookingRequest->requester()->phoneNumber()
            ),
            $bookingRequest->comment()
        );

        $this->availabilityFinder->itShouldFind($bookingRequest, $availabilities);
        $this->boatRepository->itShouldFind($bookingRequest->boatId(), $boat);
        $this->bookingRequestRepository->itShouldSave($bookingRequest);

        ($this->handler)($command);

        $this->assertTrue($bookingRequest->isAvailable());
        $this->assertEquals($bookingPrice, $bookingRequest->price());

    }

//    public function testItShouldCreateBookingRequestUnavailableByPassengers()
//    {
//        //TODO move to BoatAvailabilityFinderTest
//    }
//
//    public function testItShouldCreateBookingRequestUnavailableByDates()
//    {
//        //TODO move to BoatAvailabilityFinderTest
//    }
//
//    public function testItShouldCreateBookingRequestWithManyAvailabilities()
//    {
//        //TODO move to BoatAvailabilityFinderTest
//    }


}

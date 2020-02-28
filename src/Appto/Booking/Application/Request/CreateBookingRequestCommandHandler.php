<?php

namespace Appto\Booking\Application\Request;

use Appto\Booking\Domain\Request\BoatId;
use Appto\Booking\Domain\Request\BookingRequest;
use Appto\Booking\Domain\Request\BookingRequestChecker;
use Appto\Booking\Domain\Request\BookingRequestId;
use Appto\Booking\Domain\Request\BookingRequestRepository;
use Appto\Booking\Domain\Request\PortId;
use Appto\Booking\Domain\Request\PriceCalculator;
use Appto\Booking\Domain\Request\Requester;
use Appto\Common\Domain\DateTime\TimePeriod;
use Appto\Common\Domain\Number\NaturalNumber;

class CreateBookingRequestCommandHandler
{
    private $bookingRequestRepository;
    private $bookingRequestChecker;
    private $bookingPriceCalculator;

    public function __construct(
        BookingRequestRepository $bookingRequestRepository,
        BookingRequestChecker $bookingRequestChecker,
        PriceCalculator $bookingPriceCalculator
    ) {
        $this->bookingRequestRepository = $bookingRequestRepository;
        $this->bookingRequestChecker = $bookingRequestChecker;
        $this->bookingPriceCalculator = $bookingPriceCalculator;
    }

    public function __invoke(CreateBookingRequestCommand $command): void
    {
        $bookingRequest = new BookingRequest(
            new BookingRequestId($command->bookingRequestId()),
            new BoatId($command->boatId()),
            new PortId($command->portId()),
            new NaturalNumber($command->numberOfPassengers()),
            new TimePeriod($command->startDate(), $command->endDate()),
            new Requester(
                $command->requester()->name,
                $command->requester()->email,
                $command->requester()->phoneNumber,
                ),
            $command->comment()
        );

        if ($this->bookingRequestChecker->check($bookingRequest)){
            $bookingRequest->makeAvailable();
            $bookingRequest->updatePrice(
                $this->bookingPriceCalculator->calculate($bookingRequest)
            );
        } else {
            $bookingRequest->makeUnavailable();
        }

        $this->bookingRequestRepository->save($bookingRequest);
    }
}

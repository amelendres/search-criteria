<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine;

use Appto\Booking\Domain\Request\BookingRequest;
use Appto\Booking\Domain\Request\BookingRequestRepository;
use Appto\Booking\Infrastructure\Persistence\Doctrine\Entity\DoctrineBookingRequestEntityRepository;

class DoctrineBookingRequestRepository implements BookingRequestRepository
{
    private $repository;

    public function __construct(DoctrineBookingRequestEntityRepository $doctrineRepository)
    {
        $this->repository = $doctrineRepository;
    }


    public function save(BookingRequest $bookingRequest) : void
    {
        $this->repository->save($bookingRequest);
    }

    public function find(string $bookingRequestId) : ?BookingRequest
    {
        return $this->repository->find($bookingRequestId);
    }
}

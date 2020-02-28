<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine;

use Appto\Booking\Domain\Boat\Boat;
use Appto\Booking\Domain\Boat\BoatRepository;
use Appto\Booking\Infrastructure\Persistence\Doctrine\Entity\DoctrineBookingBoatEntityRepository;

class DoctrineBookingBoatRepository implements BoatRepository
{
    private $repository;

    public function __construct(DoctrineBookingBoatEntityRepository $doctrineRepository)
    {
        $this->repository = $doctrineRepository;
    }


    public function save(Boat $boat) : void
    {
        $this->repository->save($boat);
    }

    public function find(string $bookingRequestId) : ?Boat
    {
        return $this->repository->find($bookingRequestId);
    }
}

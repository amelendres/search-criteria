<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine\Entity;

use Appto\Booking\Domain\Request\BookingRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DoctrineBookingRequestEntityRepository extends ServiceEntityRepository
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, BookingRequest::class);
    }

    public function save(BookingRequest $booking): void
    {
        $this->registry->getManager()->persist($booking);
    }
}

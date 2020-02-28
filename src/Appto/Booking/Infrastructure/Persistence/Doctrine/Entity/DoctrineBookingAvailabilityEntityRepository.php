<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine\Entity;

use Appto\Booking\Domain\Availability\Availability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DoctrineBookingAvailabilityEntityRepository extends ServiceEntityRepository
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, Availability::class);
    }

    public function save(Availability $availability): void
    {
        $this->registry->getManager()->persist($availability);
    }
}

<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine\Entity;

use Appto\Booking\Domain\Boat\Boat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DoctrineBookingBoatEntityRepository extends ServiceEntityRepository
{
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, Boat::class);
    }

    public function save(Boat $boat): void
    {
        $this->registry->getManager()->persist($boat);
    }
}

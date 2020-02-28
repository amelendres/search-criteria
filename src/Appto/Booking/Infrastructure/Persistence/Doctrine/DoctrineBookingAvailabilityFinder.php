<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine;

use Appto\Booking\Domain\Availability\Availability;
use Appto\Booking\Domain\Request\AvailabilityFinder;
use Appto\Booking\Domain\Request\BookingRequest;
use Appto\Booking\Infrastructure\Persistence\Doctrine\Entity\DoctrineBookingAvailabilityEntityRepository;


class DoctrineBookingAvailabilityFinder implements AvailabilityFinder
{
    private $availabilities;

    private $repository;

    public function __construct(DoctrineBookingAvailabilityEntityRepository $doctrineRepository)
    {
        $this->repository = $doctrineRepository;
    }

    /**
     * @return Availability[]
     */
    public function find(BookingRequest $bookingRequest) : array
    {
        $index = $bookingRequest->id()->value();
        if(isset($this->availabilities[$index])){
            return $this->availabilities[$index];
        }

        $queryBuilder = $this->repository->createQueryBuilder('a');
        $queryBuilder
            ->where('a.boatId.value = :boatId')
            ->andWhere('a.portId.value = :portId')
            ->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->between('a.timePeriod.startDate', ':start', ':end'),
                $queryBuilder->expr()->between('a.timePeriod.endDate', ':start', ':end')
            ))
            ->setParameter('boatId', $bookingRequest->boatId())
            ->setParameter('portId', $bookingRequest->portId())
            ->setParameter('start', $bookingRequest->bookingDates()->startDate())
            ->setParameter('end', $bookingRequest->bookingDates()->endDate())
            ->orderBy('a.timePeriod.startDate', 'ASC');

        $query = $queryBuilder->getQuery();
        
        $this->availabilities[$index] = $query->getResult();
        return $this->availabilities[$index];
    }
}

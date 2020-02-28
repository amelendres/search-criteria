<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine\Fixtures\Availability;

use Appto\Booking\Domain\Availability\Availability;
use Appto\Booking\Domain\Availability\AvailabilityId;
use Appto\Booking\Domain\Availability\BoatId;
use Appto\Booking\Domain\Availability\PortId;
use Appto\Common\Domain\DateTime\TimePeriod;
use Appto\Common\Domain\Money\Currency;
use Appto\Common\Domain\Money\Price;
use Appto\Common\Infrastructure\Persistence\Doctrine\FixtureLoader;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class AvailabilityLoader extends FixtureLoader
{
    public const REFERENCE = 'availability';

    public function load(ObjectManager $manager)
    {
        $content = Yaml::parseFile(\dirname(__DIR__).'/Availability/dev.yml');

        foreach ($content[self::REFERENCE] as $id => $data) {
            $object = new Availability(
                new AvailabilityId($id) ,
                new BoatId($data['boatId']),
                new PortId($data['portId']),
                new TimePeriod(
                    new \DateTime($data['timePeriod']['startDate']),
                    new \DateTime($data['timePeriod']['endDate'])
                ),
                new Price(
                    $data['dailyPrice']['amount'],
                    new Currency($data['dailyPrice']['currency'])
                )
            );
            $manager->persist($object);
            $this->addReference(self::REFERENCE.'_'.$id, $object);
        }

        $manager->flush();
    }
}

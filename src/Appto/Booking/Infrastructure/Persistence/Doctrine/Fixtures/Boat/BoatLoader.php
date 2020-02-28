<?php

namespace Appto\Booking\Infrastructure\Persistence\Doctrine\Fixtures\Boat;

use Appto\Booking\Domain\Boat\Boat;
use Appto\Booking\Domain\Boat\BoatId;
use Appto\Booking\Domain\Boat\OwnerId;
use Appto\Common\Domain\Number\NaturalNumber;
use Appto\Common\Infrastructure\Persistence\Doctrine\FixtureLoader;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class BoatLoader extends FixtureLoader
{
    public const REFERENCE = 'boat';

    public function load(ObjectManager $manager)
    {
        $content = Yaml::parseFile(\dirname(__DIR__).'/Boat/dev.yml');

        foreach ($content['boat'] as $id => $data) {
            $boat = new Boat(
                new BoatId($id) ,
                new OwnerId($data['ownerId']),
                new NaturalNumber($data['numberOfPassengers']),
                $data['length'],
                $data['bookingCommissionPercent']
            );
            $manager->persist($boat);
            $this->addReference(self::REFERENCE.'_'.$id, $boat);
        }

        $manager->flush();
    }
}

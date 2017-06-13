<?php

// AppBundle/DataFixtures/ORM/ScenarioData.php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Scenario;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;


class ScenarioData implements FixtureInterface {

    public function load(ObjectManager $manager)
    {
        $scenario1 = new Scenario();
        $scenario1->setName('Premier scenario');
        $scenario1->setClientStart('13000');
        $scenario1->setPeriodicity('3');
        $scenario1->setClientAdd('10');
        $scenario1->setEnergyCost('10000');
        $scenario1->setCost('10000');
        $scenario1->setIsBookmarked(TRUE);
        $scenario1->setCreatedAt(new \DateTime('now'));

        $scenario2 = new Scenario();
        $scenario2->setName('deuxieme scenario');
        $scenario2->setClientStart('13900');
        $scenario2->setPeriodicity('3');
        $scenario2->setClientAdd('10');
        $scenario1->setEnergyCost('10000');
        $scenario2->setCost('100890');
        $scenario2->setIsBookmarked(FAlse);
        $scenario2->setCreatedAt(new \DateTime('now'));

        $manager->persist($scenario1);
        $manager->flush();
    }
}
?>
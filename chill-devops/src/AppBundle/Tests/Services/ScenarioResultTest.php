<?php

namespace AppBundle\Tests\Services;

use AppBundle\Entity\Scenario;
use AppBundle\Services\ScenarioResult;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ScenarioResultTest extends WebTestCase
{
    public function testGetTotalClientsByPeriodicityWithScenarioObject()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();
        $service = $container->get('app_dashboard_scenario_result');

        $scenario = new Scenario();
        $scenario->setClientStart(100);
        $scenario->setPeriodicity(5);
        $scenario->setClientAdd(1);

        $result = $service->getTotalClientsByPeriodicity($scenario);
        $this->assertEquals(111, $result[ScenarioResult::TEST_DURATION]);

    }

    public function testGetTotalClientsByPeriodicityWithoutScenarioObject()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();
        $service = $container->get('app_dashboard_scenario_result');

        $scenario = ["clientStart" => 100, "periodicity" => 5, "clientAdd" => 1];

        $result = $service->getTotalClientsByPeriodicity($scenario);
        $this->assertEquals(111, $result[ScenarioResult::TEST_DURATION]);

    }

    public function testGetgetPricesAndServers()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();
        $service = $container->get('app_dashboard_scenario_result');

        $scenario = new Scenario();
        $scenario->setClientStart(100);
        $scenario->setPeriodicity(5);
        $scenario->setClientAdd(1);

        $result = $service->getPricesAndServers($scenario);

        $this->assertEquals(302, $result[35]["GreenPriceByMonth"]);
        $this->assertLessThan(3.2, $result[35]["GreenByClientByMonth"]);
        $this->assertEquals(107, $result[40]["Clients"]);
        $this->assertEquals(0, $result[40]["BuyingCost"]);
        $this->assertLessThan(3.3, $result[60]["ByClientByMonth"]);
    }
}
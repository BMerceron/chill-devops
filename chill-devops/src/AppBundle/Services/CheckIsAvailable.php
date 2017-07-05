<?php


namespace AppBundle\Services;


use Symfony\Component\DependencyInjection\Container;

class CheckIsAvailable
{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * @param $datas
     * @return bool
     */
    public function isAvailable($datas){

        $totalClient = $this->container->get('app_dashboard_scenario_result')->getTotalClientsByPeriodicity($datas);

        if ($totalClient[ScenarioResult::TEST_DURATION] > ScenarioResult::MAX_CHARGE) {

            return false;
        }
        return true;
    }
}
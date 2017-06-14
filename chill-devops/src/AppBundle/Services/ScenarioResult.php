<?php


namespace AppBundle\Services;

use AppBundle\Entity\Scenario;

class ScenarioResult
{
    const TEST_DURATION = 60;
    /**
     * @param Scenario $scenario
     * @return array|void
     */
    public function getTotalClientsByPeriodicity(Scenario $scenario)
    {
        if (!$scenario instanceof Scenario) {
            return;
        }

        $periodicity = $scenario->getPeriodicity();
        $clientStart = $scenario->getClientStart();
        $clientAdd = $scenario->getClientAdd();
        $total = [];

        $total[$periodicity]=$clientStart;
        for ( $i = $periodicity + $periodicity; $i <= self::TEST_DURATION; $i+=$periodicity ){
            $total[$i] = $total[$i-$periodicity] + ($total[$i-$periodicity]/$clientAdd);
        }

        return $total;
    }
}
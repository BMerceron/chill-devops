<?php


namespace AppBundle\Services;

use AppBundle\Entity\Scenario;
use phpDocumentor\Reflection\Types\Integer;

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
        $clientAdd = $scenario->getClientAdd()/100;
        $total = [];

        $total[$periodicity]=$clientStart;

        for ( $i = $periodicity + $periodicity; $i <= self::TEST_DURATION; $i+=$periodicity ){
            $total[$i] = round($total[$i-$periodicity] + ($total[$i-$periodicity]*($clientAdd)));
            if ($i + $periodicity > self::TEST_DURATION) {
                $nbMonthprorata = self::TEST_DURATION - $i;
                $total[self::TEST_DURATION] = round(($total[$i]*($clientAdd*($nbMonthprorata/$periodicity))) + $total[$i]);
            }
        }

        return $total;
    }

    public function getOfflineServers(array $servers){

        $offline = 0;

        foreach ($servers as $key=>$value){
            if ($value == "offline"){
                $offline++;
            }
        }


        return $offline;
    }

    public function getOnlineServers(array $servers){

        $online = 0;
        foreach ($servers as $key=>$value){
            if ($value == "online"){
                $online++;
            }
        }
        return $online;
    }

    public function putOnlineServers($number, array $servers){

        $time = 0;

        foreach($servers as $key=>$value){
            if ($value == "offline"){
                $value = "online";
                $time++;
                if ($time == $number){
                    break;
                }
            }
        }

        return $servers;
    }

    public function putOfflineServers($number, array $servers){

        $time = 0;

        foreach($servers as $key=>$value){
            if ($value == "online"){
                $value = "offline";
                $time++;
                if ($time == $number){
                    break;
                }
            }
        }

        return $servers;
    }

    public function getPricesAndServers(Scenario $scenario)
    {
        if (!$scenario instanceof Scenario) {
            return;
        }

        $totalClients = $this->getTotalClientsByPeriodicity($scenario);

        $one = ["capacity" =>6500, "buyingPrice" =>850, "priceByMonth" =>20];
        $two = ["capacity" =>8000, "buyingPrice" =>1200, "priceByMonth" =>30];
        $three = ["capacity" =>10000, "buyingPrice" =>1500, "priceByMonth" =>50];


        $result = [];

        $servers = ["one"=>[], "two"=>[], "three"=>[]];

        foreach ($totalClients as $key => $value){

            $needed = ["one"=>0,"two"=>0,"three"=>0];

            $result[$key]["Client"] = $value;
            $result[$key]["PriceByMonth"] = 0;
            $result[$key]["BuyingCost"] = 0;

            //how many servers do we need

            while($value > 0){
                if($value >= $three["capacity"]){
                    $value -= $three["capacity"];
                    $needed["three"]++;
                }
                elseif ($value < $three["capacity"] && $value >= $two["capacity"]) {
                    $needed["three"]++;
                    break;
                }elseif ($value < $two["capacity"] && $value > $one["capacity"]) {
                    $needed["two"]++;
                    break;
                }elseif ($value > $one["capacity"]) {
                    $value -= $one["capacity"];
                    $needed["two"]++;
                }else{
                    $value = 0;
                    $needed["one"]++;
                }
            }
            //we get offline servers from the customer, and put them online if necessary

            if (!empty($servers)){

                $offlineThree = $this->getOfflineServers($servers["three"]);


                //$offlineTwo = self::getOfflineServers($result[$key]["Server"]["two"]);
                //$offlineOne = self::getOfflineServers($result[$key]["Server"]["one"]);

                if ($offlineThree >0 && $needed["three"] >0){
                    if(($needed["three"] - $offlineThree)>=0){
                        // puting servers online, even if we don't have enough
                        $result[$key]["Server"]["three"] = $this->putOnlineServers($offlineThree, $servers["three"]);
                        $needed["three"]-=$needed["three"]-$offlineThree;
                    }else{
                        // puting online servers, we have enough
                        $servers["three"] = $this->putOnlineServers($needed["three"], $servers["three"]);
                        $needed["three"]=0;
                    }
                }

                $onlineThree = $this->getOnlineServers($servers["three"]);

                if ($onlineThree >0 && $needed["three"] > 0 ){

                    if (($onlineThree - $needed["three"])>=0)
                    {
                        $servers["three"] = $this->putOfflineServers($needed["three"], $servers["three"]);
                        $needed["three"]=0;
                    }elseif($needed["three"] - $onlineThree > 0){
                        $needed["three"]=$needed["three"] - $onlineThree;
                    }

                }

            }
            if ($needed["three"]>0){
                //create new servers that are needed + add buying price to bill
                for ($i=1; $i<=$needed["three"]; $i++) {
                    array_push($servers["three"], "online");
                    $result[$key]["BuyingCost"] += $three["buyingPrice"];
                }
            }

            if (!empty($servers["three"])){
                $result[$key]["PriceByMonth"] += (($this->getOnlineServers($servers["three"]))*$three['priceByMonth']);
            }
            dump($needed);
        }
        dump($result);die;

    }
}
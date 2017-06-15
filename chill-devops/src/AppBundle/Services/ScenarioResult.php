<?php


namespace AppBundle\Services;

use AppBundle\Entity\Scenario;

class ScenarioResult
{
    const TEST_DURATION = 60;
    const MAX_CHARGE = 5000000;

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

    /**
     * @param array $servers
     * @return int
     */
    public function getOfflineServers(array $servers){

        $offline = 0;

        foreach ($servers as $key=>$value){
            if ($value == "offline"){
                $offline++;
            }
        }


        return $offline;
    }

    /**
     * @param array $servers
     * @return int
     */
    public function getOnlineServers(array $servers){

        $online = 0;
        foreach ($servers as $key=>$value){
            if ($value == "online"){
                $online++;
            }
        }
        return $online;
    }

    /**
     * @param $number
     * @param array $servers
     * @return array
     */
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

    /**
     * @param $number
     * @param array $servers
     * @return array
     */
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

    /**
     * @param Scenario $scenario
     * @return array|void
     */
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
            $result[$key]["lastmonth"] = $key;

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
//            TODO - Need refacto
            if (!empty($servers)){

                $offlineThree = $this->getOfflineServers($servers["three"]);
                $offlineTwo = $this->getOfflineServers($servers["two"]);
                $offlineOne = $this->getOfflineServers($servers["one"]);


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

                if ($offlineTwo >0 && $needed["two"] >0){
                    if(($needed["two"] - $offlineTwo)>=0){
                        // puting servers online, even if we don't have enough
                        $result[$key]["Server"]["two"] = $this->putOnlineServers($offlineTwo, $servers["two"]);
                        $needed["two"]-=$needed["two"]-$offlineTwo;
                    }else{
                        // puting online servers, we have enough
                        $servers["two"] = $this->putOnlineServers($needed["two"], $servers["two"]);
                        $needed["two"]=0;
                    }
                }

                if ($offlineOne >0 && $needed["one"] >0){
                    if(($needed["one"] - $offlineOne)>=0){
                        // puting servers online, even if we don't have enough
                        $result[$key]["Server"]["one"] = $this->putOnlineServers($offlineOne, $servers["one"]);
                        $needed["one"]-=$needed["one"]-$offlineOne;
                    }else{
                        // puting online servers, we have enough
                        $servers["one"] = $this->putOnlineServers($needed["one"], $servers["one"]);
                        $needed["one"]=0;
                    }
                }

                $onlineThree = $this->getOnlineServers($servers["three"]);
                $onlineTwo = $this->getOnlineServers($servers["two"]);
                $onlineOne = $this->getOnlineServers($servers["one"]);

                if ($onlineThree >0 && $needed["three"] > 0 ){
                    if (($onlineThree - $needed["three"])>=0){
                        $servers["three"] = $this->putOfflineServers($needed["three"], $servers["three"]);
                        $needed["three"]=0;
                    }elseif($needed["three"] - $onlineThree > 0){
                        $needed["three"]=$needed["three"] - $onlineThree;
                    }
                }

                if ($onlineTwo >0 && $needed["two"] > 0 ){
                    if (($onlineTwo - $needed["two"])>=0) {
                        $servers["three"] = $this->putOfflineServers($needed["two"], $servers["two"]);
                        $needed["two"]=0;
                    } elseif($needed["two"] - $onlineTwo > 0){
                        $needed["two"]=$needed["two"] - $onlineTwo;
                    }
                }

                if ($onlineOne >0 && $needed["one"] > 0 ){
                    if (($onlineOne - $needed["one"])>=0) {
                        $servers["one"] = $this->putOfflineServers($needed["one"], $servers["one"]);
                        $needed["one"]=0;
                    } elseif($needed["one"] - $onlineOne > 0){
                        $needed["one"]=$needed["one"] - $onlineOne;
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

            if ($needed["two"]>0){
                //create new servers that are needed + add buying price to bill
                for ($i=1; $i<=$needed["two"]; $i++) {
                    array_push($servers["two"], "online");
                    $result[$key]["BuyingCost"] += $two["buyingPrice"];
                }
            }

            if ($needed["one"]>0){
                //create new servers that are needed + add buying price to bill
                for ($i=1; $i<=$needed["one"]; $i++) {
                    array_push($servers["one"], "online");
                    $result[$key]["BuyingCost"] += $one["buyingPrice"];
                }
            }

            if (!empty($servers["three"])){
                $result[$key]["PriceByMonth"] += (($this->getOnlineServers($servers["three"]))*$three['priceByMonth']);
            }

            if (!empty($servers["two"])){
                $result[$key]["PriceByMonth"] += (($this->getOnlineServers($servers["two"]))*$two['priceByMonth']);
            }

            if (!empty($servers["one"])){
                $result[$key]["PriceByMonth"] += (($this->getOnlineServers($servers["one"]))*$one['priceByMonth']);
            }
        }
        return $result;

    }
}
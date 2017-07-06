<?php


namespace AppBundle\Services;

use AppBundle\Entity\Scenario;

class ScenarioResult
{
    const TEST_DURATION = 60;
    const MAX_CHARGE = 5000000;

    private $periodicity;

    private $servers = [];

    private $totalPrice;

    private $totalGreenPrice;
    /**
     * @param Scenario $scenario
     * @return array|void
     */
    public function getTotalClientsByPeriodicity($scenario)
    {
        if ($scenario instanceof Scenario) {
            $this->periodicity = $scenario->getPeriodicity();
            $clientStart = $scenario->getClientStart();
            $clientAdd = $scenario->getClientAdd()/100;
        } else {
            $this->periodicity = $scenario['periodicity'];
            $clientStart = $scenario['clientStart'];
            $clientAdd = $scenario['clientAdd']/100;
        }

        $total = [];

        $total[$this->periodicity]=$clientStart;
        $nextPeriodicity = $this->periodicity + $this->periodicity;

        if ($nextPeriodicity > self::TEST_DURATION) {
            $nbMonthprorata = self::TEST_DURATION - $this->periodicity;
            $total[self::TEST_DURATION] = round(($total[$this->periodicity]*($clientAdd*($nbMonthprorata/$this->periodicity))) + $total[$this->periodicity]);
        }

        for ( $i = $this->periodicity + $this->periodicity; $i <= self::TEST_DURATION; $i+=$this->periodicity ){
            $total[$i] = round($total[$i-$this->periodicity] + ($total[$i-$this->periodicity]*($clientAdd)));
            if ($i + $this->periodicity > self::TEST_DURATION) {
                $nbMonthprorata = self::TEST_DURATION - $i;
                $total[self::TEST_DURATION] = round(($total[$i]*($clientAdd*($nbMonthprorata/$this->periodicity))) + $total[$i]);
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

        for($i=0;$i<$number;$i++){
            if ($servers[$i]=="offline"){
                $servers[$i]="online";
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

        for($i=0;$i<$number;$i++){
            if ($servers[$i]=="online"){
                $servers[$i]="offline";
            }
        }
        return $servers;
    }

    /**
     * @param $server
     * @return array
     */
    public function getInfoServer($server)
    {
        switch ($server) {
            case "one":
                return ["capacity" =>465, "buyingPrice" =>424, "priceByMonth" =>355, "greenBuyingPrice" =>1689, "greenPriceByMonth" =>302];
            case "two":
                return ["capacity" =>595, "buyingPrice" =>817, "priceByMonth" =>371, "greenBuyingPrice" =>1981, "greenPriceByMonth" =>315];
            case "three":
                return ["capacity" =>1323, "buyingPrice" =>1192, "priceByMonth" =>371, "greenBuyingPrice" =>2361, "greenPriceByMonth" =>315];
        }

        return ["capacity" =>0, "buyingPrice" =>0, "priceByMonth" =>0, "greenBuyingPrice" =>0, "greenPriceByMonth" =>0 ];
    }

    /**
     * @param Scenario $scenario
     * @return array
     * @throws \Exception
     */
    public function getPricesAndServers($scenario)
    {
        if (!$scenario instanceof Scenario) {
            throw new \Exception('Need an instance of Scenario.');
        }
        $totalClients = $this->getTotalClientsByPeriodicity($scenario);

        $one = $this->getInfoServer("one");
        $two = $this->getInfoServer("two");
        $three = $this->getInfoServer("three");

        $result = [];
        $servers = ["one"=>[], "two"=>[], "three"=>[]];
        $activity = $servers;

        $totalPrice = 0;
        $totalGreenPrice = 0;

        foreach ($totalClients as $key => $value) {

            $needed = ["one" => 0, "two" => 0, "three" => 0];

            $result[$key]["Clients"] = $value;
            $result[$key]["PriceByMonth"] = 0;
            $result[$key]["GreenPriceByMonth"] = 0;
            $result[$key]["BuyingCost"] = 0;
            $result[$key]["GreenBuyingCost"] = 0;
            $result[$key]["ByClientByMonth"] = 0;
            $result[$key]["GreenByClientByMonth"] = 0;
            $result[$key]["LastMonth"] = $key;

            //how many servers do we need
            while ($value > 0) {
                if ($value >= $three["capacity"]) {
                    $value -= $three["capacity"];
                    $needed["three"]++;
                } elseif ($value < $three["capacity"] && $value >= $two["capacity"]) {
                    $needed["three"]++;
                    break;
                } elseif ($value < $two["capacity"] && $value > $one["capacity"]) {
                    $needed["two"]++;
                    break;
                } elseif ($value > $one["capacity"]) {
                    $value -= $one["capacity"];
                    $needed["two"]++;
                } else {
                    $value = 0;
                    $needed["one"]++;
                }
            }
            //we get offline servers from the customer, and put them online if necessary
//            TODO - Need refacto
            if (!empty($servers)) {

                $offlineThree = $this->getOfflineServers($servers["three"]);
                $offlineTwo = $this->getOfflineServers($servers["two"]);
                $offlineOne = $this->getOfflineServers($servers["one"]);

                $onlineThree = $this->getOnlineServers($servers["three"]);
                $onlineTwo = $this->getOnlineServers($servers["two"]);
                $onlineOne = $this->getOnlineServers($servers["one"]);


                if ($offlineThree > 0 && $needed["three"] > 0) {
                    if (($needed["three"] - $offlineThree) >= 0) {
                        // puting servers online, even if we don't have enough
                        $servers["three"] = $this->putOnlineServers($offlineThree, $servers["three"]);
                        $needed["three"] -= $offlineThree;
                    } else {
                        // puting online servers, we have enough
                        $servers["three"] = $this->putOnlineServers($needed["three"], $servers["three"]);
                        $needed["three"] = 0;
                    }
                } elseif ($onlineThree > 0 && $needed["three"] >= 0) {
                    if (($onlineThree - $needed["three"]) >= 0) {
                        $servers["three"] = $this->putOfflineServers(($onlineThree - $needed["three"]), $servers["three"]);
                        $needed["three"] = 0;
                    } elseif ($needed["three"] - $onlineThree > 0) {
                        $needed["three"] -= $onlineThree;
                    }
                }

                if ($offlineTwo > 0 && $needed["two"] > 0) {
                    if (($needed["two"] - $offlineTwo) >= 0) {
                        // puting servers online, even if we don't have enough
                        $servers["two"] = $this->putOnlineServers($offlineTwo, $servers["two"]);
                        $needed["two"] -= $offlineTwo;
                    } else {
                        // puting online servers, we have enough
                        $servers["two"] = $this->putOnlineServers($needed["two"], $servers["two"]);
                        $needed["two"] = 0;
                    }
                } elseif ($onlineTwo > 0 && $needed["two"] >= 0) {
                    if (($onlineTwo - $needed["two"]) >= 0) {
                        $servers["two"] = $this->putOfflineServers(($onlineTwo - $needed["two"]), $servers["two"]);
                        $needed["two"] = 0;
                    } elseif ($needed["two"] - $onlineTwo > 0) {
                        $needed["two"] = $needed["two"] - $onlineTwo;
                    }
                }

                if ($offlineOne > 0 && $needed["one"] > 0) {
                    if (($needed["one"] - $offlineOne) >= 0) {
                        // puting servers online, even if we don't have enough
                        $servers["one"] = $this->putOnlineServers($offlineOne, $servers["one"]);
                        $needed["one"] -= $offlineOne;
                    } else {
                        // puting online servers, we have enough
                        $servers["one"] = $this->putOnlineServers($needed["one"], $servers["one"]);
                        $needed["one"] = 0;
                    }
                } elseif ($onlineOne > 0 && $needed["one"] >= 0) {
                    if (($onlineOne - $needed["one"]) > 0) {
                        $servers["one"] = $this->putOfflineServers(($onlineOne - $needed["one"]), $servers["one"]);
                        $needed["one"] = 0;
                    } elseif ($needed["one"] - $onlineOne > 0) {
                        $needed["one"] = $needed["one"] - $onlineOne;
                    } else {
                        $needed["one"] = 0;
                    }
                }
            }
            if ($needed["three"] > 0) {
                //create new servers that are needed + add buying price to bill
                for ($i = 1; $i <= $needed["three"]; $i++) {
                    array_push($servers["three"], "online");
                    $result[$key]["BuyingCost"] += $three["buyingPrice"];
                    $result[$key]["GreenBuyingCost"] += $three["greenBuyingPrice"];
                    $totalPrice += $three["buyingPrice"];
                    $totalGreenPrice += $three["greenBuyingPrice"];
                }
            }
            if ($needed["two"] > 0) {
                for ($i = 1; $i <= $needed["two"]; $i++) {
                    array_push($servers["two"], "online");
                    $result[$key]["BuyingCost"] += $two["buyingPrice"];
                    $result[$key]["GreenBuyingCost"] += $two["greenBuyingPrice"];
                    $totalPrice += $two["buyingPrice"];
                    $totalGreenPrice += $two["greenBuyingPrice"];
                }
            }
            if ($needed["one"] > 0) {
                for ($i = 1; $i <= $needed["one"]; $i++) {
                    array_push($servers["one"], "online");
                    $result[$key]["BuyingCost"] += $one["buyingPrice"];
                    $result[$key]["GreenBuyingCost"] += $one["greenBuyingPrice"];
                    $totalPrice += $one["buyingPrice"];
                    $totalGreenPrice += $one["greenBuyingPrice"];

                }
            }
            if (!empty($servers["three"])) {
                $result[$key]["PriceByMonth"] += (($this->getOnlineServers($servers["three"])) * $three['priceByMonth']);
                $result[$key]["ByClientByMonth"] += ((($this->getOnlineServers($servers["three"])) * $three['priceByMonth']))/$result[$key]["Clients"];
                $result[$key]["GreenByClientByMonth"] += ((($this->getOnlineServers($servers["three"])) * $three['greenPriceByMonth']))/$result[$key]["Clients"];
                $result[$key]["GreenPriceByMonth"] += (($this->getOnlineServers($servers["three"])) * $three['greenPriceByMonth']);
                $totalPrice += ($three['priceByMonth'] * $this->periodicity);
                $totalGreenPrice += ($three['greenPriceByMonth'] * $this->periodicity);
            }
            if (!empty($servers["two"])) {
                $result[$key]["PriceByMonth"] += (($this->getOnlineServers($servers["two"])) * $two['priceByMonth']);
                $result[$key]["ByClientByMonth"] += ((($this->getOnlineServers($servers["two"])) * $two['priceByMonth']))/$result[$key]["Clients"];
                $result[$key]["GreenByClientByMonth"] += ((($this->getOnlineServers($servers["two"])) * $two['greenPriceByMonth']))/$result[$key]["Clients"];
                $result[$key]["GreenPriceByMonth"] += (($this->getOnlineServers($servers["two"])) * $two['greenPriceByMonth']);
                $totalPrice += ($two['priceByMonth'] * $this->periodicity);
                $totalGreenPrice += ($two['greenPriceByMonth'] * $this->periodicity);
            }
            if (!empty($servers["one"])) {
                $result[$key]["PriceByMonth"] += (($this->getOnlineServers($servers["one"])) * $one['priceByMonth']);
                $result[$key]["ByClientByMonth"] += ((($this->getOnlineServers($servers["one"])) * $one['priceByMonth']))/$result[$key]["Clients"];
                $result[$key]["GreenByClientByMonth"] += ((($this->getOnlineServers($servers["one"])) * $one['greenPriceByMonth']))/$result[$key]["Clients"];
                $result[$key]["GreenPriceByMonth"] += (($this->getOnlineServers($servers["one"])) * $one['greenPriceByMonth']);
                $totalPrice += ($one['priceByMonth'] * $this->periodicity);
                $totalGreenPrice += ($one['greenPriceByMonth'] * $this->periodicity);

            }

            foreach ($servers as $type => $serv) {

                if (!empty($serv)) {
                    foreach ($serv as $server => $status) {

                        if ($status == "online") {
                            $activity[$type][$server][]= $key;
                        }
                    }
                }

            }
        }

        foreach ($activity as $type => $serv){
            foreach ($serv as $id => $value){
                switch ($type){
                    case "one":
                        $monthly = $one["buyingPrice"]/(sizeof($value)*$this->periodicity);
                        $greenMonthly = $one["greenBuyingPrice"]/(sizeof($value)*$this->periodicity);
                        break;
                    case "two":
                        $monthly = $two["buyingPrice"]/(sizeof($value)*$this->periodicity);
                        $greenMonthly = $two["greenBuyingPrice"]/(sizeof($value)*$this->periodicity);
                        break;
                    case "three":
                        $monthly =$three["buyingPrice"]/(sizeof($value)*$this->periodicity);
                        $greenMonthly = $three["greenBuyingPrice"]/(sizeof($value)*$this->periodicity);
                        break;
                }
                foreach ($value as $numP => $period){
                    $result[$period]["ByClientByMonth"] += $monthly/$result[$period]["Clients"];
                    $result[$period]["GreenByClientByMonth"] += $greenMonthly/$result[$period]["Clients"];
                }
            }
        }

        $this->servers = $servers;
        $this->totalPrice = $totalPrice;
        $this->totalGreenPrice = $totalGreenPrice;
        return $result;

    }

    /**
     * @return array
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return mixed
     */
    public function getTotalGreenPrice()
    {
        return $this->totalGreenPrice;
    }


}
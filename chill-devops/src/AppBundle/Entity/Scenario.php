<?php

namespace AppBundle\Entity;


use DateTime;
use Symfony\Component\Finder\Iterator\DateRangeFilterIterator;

class Scenario
{
    /**
     * @var string
     */
    private $id;

    /**
     * Scenario need customer start number to simulation
     * @var integer
     */
    private $clientStart;

    /**
     * Periodicity of the load (month)
     * @var integer
     */
    private $periodicity;

    /**
     * Percentage of additional customers
     * @var integer
     */
    private $clientAdd;

    /**
     * JSON costs by month
     * @var string
     */
    private $cost;

    /**
     * Energy cost by month
     * @var integer
     */
    private $energyCost;

    /**
     * Check if bookmarked
     * @var boolean
     */
    private $isBookmarked;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $name;

    /**
     * Scenario constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Scenario
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientStart()
    {
        return $this->clientStart;
    }

    /**
     * @param int $clientStart
     * @return Scenario
     */
    public function setClientStart($clientStart)
    {
        $this->clientStart = $clientStart;
        return $this;
    }

    /**
     * @return int
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * @param int $periodicity
     * @return Scenario
     */
    public function setPeriodicity($periodicity)
    {
        $this->periodicity = $periodicity;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientAdd()
    {
        return $this->clientAdd;
    }

    /**
     * @param int $clientAdd
     * @return Scenario
     */
    public function setClientAdd($clientAdd)
    {
        $this->clientAdd = $clientAdd;
        return $this;
    }

    /**
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param string $cost
     * @return Scenario
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return int
     */
    public function getEnergyCost()
    {
        return $this->energyCost;
    }

    /**
     * @param int $energyCost
     * @return Scenario
     */
    public function setEnergyCost($energyCost)
    {
        $this->energyCost = $energyCost;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsBookmarked()
    {
        return $this->isBookmarked;
    }

    /**
     * @param boolean $isBookmarked
     * @return Scenario
     */
    public function setIsBookmarked($isBookmarked)
    {
        $this->isBookmarked = $isBookmarked;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Scenario
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Scenario
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


}
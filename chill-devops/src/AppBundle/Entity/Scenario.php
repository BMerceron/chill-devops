<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scenario
 *
 * @ORM\Table(name="scenario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScenarioRepository")
 */
class Scenario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="clientStart", type="integer")
     */
    private $clientStart;

    /**
     * @var int
     *
     * @ORM\Column(name="periodicity", type="integer")
     */
    private $periodicity;

    /**
     * @var int
     *
     * @ORM\Column(name="clientAdd", type="integer")
     */
    private $clientAdd;

    /**
     * @var array
     *
     * @ORM\Column(name="cost", type="json_array")
     */
    private $cost;

    /**
     * @var int
     *
     * @ORM\Column(name="energyCost", type="integer")
     */
    private $energyCost;

    /**
     * @var bool
     *
     * @ORM\Column(name="isBookmarked", type="boolean")
     */
    private $isBookmarked;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set clientStart
     *
     * @param integer $clientStart
     *
     * @return Scenario
     */
    public function setClientStart($clientStart)
    {
        $this->clientStart = $clientStart;

        return $this;
    }

    /**
     * Get clientStart
     *
     * @return int
     */
    public function getClientStart()
    {
        return $this->clientStart;
    }

    /**
     * Set periodicity
     *
     * @param integer $periodicity
     *
     * @return Scenario
     */
    public function setPeriodicity($periodicity)
    {
        $this->periodicity = $periodicity;

        return $this;
    }

    /**
     * Get periodicity
     *
     * @return int
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * Set clientAdd
     *
     * @param integer $clientAdd
     *
     * @return Scenario
     */
    public function setClientAdd($clientAdd)
    {
        $this->clientAdd = $clientAdd;

        return $this;
    }

    /**
     * Get clientAdd
     *
     * @return int
     */
    public function getClientAdd()
    {
        return $this->clientAdd;
    }

    /**
     * Set cost
     *
     * @param array $cost
     *
     * @return Scenario
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return array
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set energyCost
     *
     * @param integer $energyCost
     *
     * @return Scenario
     */
    public function setEnergyCost($energyCost)
    {
        $this->energyCost = $energyCost;

        return $this;
    }

    /**
     * Get energyCost
     *
     * @return int
     */
    public function getEnergyCost()
    {
        return $this->energyCost;
    }

    /**
     * Set isBookmarked
     *
     * @param boolean $isBookmarked
     *
     * @return Scenario
     */
    public function setIsBookmarked($isBookmarked)
    {
        $this->isBookmarked = $isBookmarked;

        return $this;
    }

    /**
     * Get isBookmarked
     *
     * @return bool
     */
    public function getIsBookmarked()
    {
        return $this->isBookmarked;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Scenario
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Scenario
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}


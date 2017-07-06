<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "Doit être d'au moins {{ limit }}",
     * )
     */
    private $clientStart;

    /**
     * @var int
     *
     * @ORM\Column(name="periodicity", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      max = 60,
     *      minMessage = "Doit être d'au moins {{ limit }}",
     *      maxMessage = "Doit être au plus{{ limit }}",
     * )
     */
    private $periodicity;

    /**
     * @var int
     *
     * @ORM\Column(name="clientAdd", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "Doit être d'au moins {{ limit }}",
     * )
     */
    private $clientAdd;

    /**
     * @var array
     *
     * @ORM\Column(name="cost", type="json_array")
     */
    private $cost;

    /**
     * @var array
     *
     * @ORM\Column(name="totalPrices", type="array", nullable=true)
     */
    private $totalPrices;

    /**
     * @var bool
     *
     * @ORM\Column(name="isBookmarked", type="boolean", nullable=true)
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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Must be at least {{ limit }}",
     * )
     */
    private $name;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Configuration")
     * @ORM\JoinTable(name="scenario_configuration",
     *      joinColumns={@ORM\JoinColumn(name="scenario_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="configuration_id", referencedColumnName="id")}
     *      )
     */
    private $servers;

    /**
     * Scenario constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->servers = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * @return array
     */
    public function getTotalPrices()
    {
        return $this->totalPrices;
    }

    /**
     * @param array $totalPrices
     * @return Scenario
     */
    public function setTotalPrices($totalPrices)
    {
        $this->totalPrices = $totalPrices;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * @param mixed $servers
     * @return Scenario
     */
    public function setServers($servers)
    {
        $this->servers = $servers;
        return $this;
    }



}


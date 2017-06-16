<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 *
 * @ORM\Table(name="configuration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigurationRepository")
 */
class Configuration
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="ram", type="integer")
     */
    private $ram;

    /**
     * @var int
     *
     * @ORM\Column(name="core", type="integer")
     */
    private $core;

    /**
     * @var int
     *
     * @ORM\Column(name="cpu", type="integer")
     */
    private $cpu;

    /**
     * @var int
     *
     * @ORM\Column(name="disk", type="integer")
     */
    private $disk;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

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
     * Set name
     *
     * @param string $name
     *
     * @return Configuration
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
     * Set ram
     *
     * @param integer $ram
     *
     * @return Configuration
     */
    public function setRam($ram)
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * Get ram
     *
     * @return int
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * @return int
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * @param int $cpu
     * @return Configuration
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;
        return $this;
    }

    /**
     * @return int
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @param int $disk
     * @return Configuration
     */
    public function setDisk($disk)
    {
        $this->disk = $disk;
        return $this;
    }

    /**
     * @return int
     */
    public function getCore()
    {
        return $this->core;
    }

    /**
     * @param int $core
     * @return Configuration
     */
    public function setCore($core)
    {
        $this->core = $core;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Configuration
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

}


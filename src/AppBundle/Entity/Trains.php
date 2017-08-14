<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="AppBundle\Entity\TrainsRepository")
* @ORM\Table(name="trains")
*/

class Trains
{
    /**
     * @var string
     *
     * @ORM\Column(name="train_type", type="string", nullable=false)
     */
    private $trainType;

    /**
     * @var string
     *
     * @ORM\Column(name="train_name", type="string", length=255, nullable=false)
     */
    private $trainName;

    /**
     * @var integer
     *
     * @ORM\Column(name="build_year", type="integer", nullable=false)
     */
    private $buildYear;

    /**
     * @var integer
     *
     * @ORM\Column(name="train_number", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $trainNumber;



    /**
     * Set trainType
     *
     * @param string $trainType
     *
     * @return Trains
     */
    public function setTrainType($trainType)
    {
        $this->trainType = $trainType;

        return $this;
    }

    /**
     * Get trainType
     *
     * @return string
     */
    public function getTrainType()
    {
        return $this->trainType;
    }

    /**
     * Set trainName
     *
     * @param string $trainName
     *
     * @return Trains
     */
    public function setTrainName($trainName)
    {
        $this->trainName = $trainName;

        return $this;
    }

    /**
     * Get trainName
     *
     * @return string
     */
    public function getTrainName()
    {
        return $this->trainName;
    }

    /**
     * Set buildYear
     *
     * @param integer $buildYear
     *
     * @return Trains
     */
    public function setBuildYear($buildYear)
    {
        $this->buildYear = $buildYear;

        return $this;
    }

    /**
     * Get buildYear
     *
     * @return integer
     */
    public function getBuildYear()
    {
        return $this->buildYear;
    }

    /**
     * Get trainNumber
     *
     * @return integer
     */
    public function getTrainNumber()
    {
        return $this->trainNumber;
    }
}

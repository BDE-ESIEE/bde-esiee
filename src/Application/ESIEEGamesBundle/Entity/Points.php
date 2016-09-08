<?php

namespace Application\ESIEEGamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Points
 */
class Points
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $value;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Application\BDEBundle\Entity\Club
     */
    private $club;


    public function __construct()
    {
        $this->date = new \DateTime;
    }

    public function __toString()
    {
        return $this->value.' points pour '.$this->club;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Points
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Points
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Points
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set club
     *
     * @param \Application\BDEBundle\Entity\Club $club
     * @return Points
     */
    public function setClub(\Application\BDEBundle\Entity\Club $club = null)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \Application\BDEBundle\Entity\Club 
     */
    public function getClub()
    {
        return $this->club;
    }
}

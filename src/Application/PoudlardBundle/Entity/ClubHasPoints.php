<?php

namespace Application\PoudlardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClubHasPoints
 */
class ClubHasPoints
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var integer
     */
    private $amount;

    /**
     * @var integer
     */
    private $bonusMalus = 0;

    /**
     * @var \Application\BDEBundle\Entity\Club
     */
    private $club;

    public function __toString()
    {
        return ''.$this->amount.' points pour '.$this->club;
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
     * Set amount
     *
     * @param integer $amount
     * @return ClubHasPoints
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set bonusMalus
     *
     * @param integer $bonusMalus
     * @return ClubHasPoints
     */
    public function setBonusMalus($bonusMalus)
    {
        $this->bonusMalus = $bonusMalus;

        return $this;
    }

    /**
     * Get bonusMalus
     *
     * @return integer 
     */
    public function getBonusMalus()
    {
        return $this->bonusMalus;
    }

    /**
     * Set club
     *
     * @param \Application\BDEBundle\Entity\Club $club
     * @return ClubHasPoints
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

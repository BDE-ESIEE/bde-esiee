<?php

namespace Application\PoudlardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * House
 */
class House
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $clubs;

    /**
     * @var integer
     */
    private $score = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return ''.$this->name;
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
     * Set name
     *
     * @param string $name
     * @return House
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
     * Add clubs
     *
     * @param \Application\BDEBundle\Entity\Club $clubs
     * @return House
     */
    public function addClub(\Application\BDEBundle\Entity\Club $clubs)
    {
        $this->clubs[] = $clubs;
        $clubs->setHouse($this);

        return $this;
    }

    /**
     * Remove clubs
     *
     * @param \Application\BDEBundle\Entity\Club $clubs
     */
    public function removeClub(\Application\BDEBundle\Entity\Club $clubs)
    {
        $this->clubs->removeElement($clubs);
        $clubs->setHouse(null);
    }

    /**
     * Get clubs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClubs()
    {
        return $this->clubs;
    }

    public function getScore()
    {
        $total = 0;

        foreach($this->clubs as $club)
        {
            $total += $club->getScore();
        }

        return $total;
    }
}

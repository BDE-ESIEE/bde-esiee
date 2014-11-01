<?php

namespace Application\PoudlardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContextInterface;

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
    private $name;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $distribution;
    /**
     * @var integer
     */
    private $total = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->distribution = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime();
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
     * @return Points
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
     * Add distribution
     *
     * @param \Application\PoudlardBundle\Entity\ClubHasPoints $distribution
     * @return Points
     */
    public function addDistribution(\Application\PoudlardBundle\Entity\ClubHasPoints $distribution)
    {
        $this->distribution[] = $distribution;

        return $this;
    }

    /**
     * Remove distribution
     *
     * @param \Application\PoudlardBundle\Entity\ClubHasPoints $distribution
     */
    public function removeDistribution(\Application\PoudlardBundle\Entity\ClubHasPoints $distribution)
    {
        $this->distribution->removeElement($distribution);
    }

    /**
     * Get distribution
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDistribution()
    {
        return $this->distribution;
    }

    /**
     * Get total
     *
     * @return integer
     */    
    public function getTotal()
    {
        $total = 0;

        foreach($this->distribution as $clubHasPoints)
        {
            $total += $clubHasPoints->getAmount() + $clubHasPoints->getBonusMalus();
        }

        return $total;
    }

    /**
     * Get total by house
     *
     * @return array
     */    
    public function getTotalByHouse()
    {
        $total = array();

        foreach($this->distribution as $clubHasPoints)
        {
            if (!array_key_exists($clubHasPoints->getClub()->getHouse()->getId(), $total))
                $total[$clubHasPoints->getClub()->getHouse()->getId()] = array(0, $clubHasPoints->getClub()->getHouse());
            $total[$clubHasPoints->getClub()->getHouse()->getId()][0] += $clubHasPoints->getAmount() + $clubHasPoints->getBonusMalus();
        }

        return $total;
    }

    public function getDistributionByHouse()
    {
        $distribution = $this->getTotalByHouse();
        $response = '<ul>';
        foreach ($distribution as $id => $value) {
            $response .= '<li>'.$value[0].' points pour '.$value[1]."</li>";
        }

        return $response.'</ul>';
    }
}

<?php

namespace Application\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LostProperty
 *
 * @ORM\Table(name="bde__lost_property")
 * @ORM\Entity(repositoryClass="Application\ServiceBundle\Repository\LostPropertyRepository")
 */
class LostProperty
{
    /**
     * @var integer
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="found", type="boolean")
     */
    private $found;


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
     * @return LostProperty
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

    public function __toString()
    {
        return ''.$this->getName();
    }

    public function __construct() {
        $this->date = new \DateTime();
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return LostProperty
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
     * Set found
     *
     * @param boolean $found
     * @return LostProperty
     */
    public function setFound($found)
    {
        $this->found = $found;

        return $this;
    }

    /**
     * Get found
     *
     * @return boolean 
     */
    public function getFound()
    {
        return $this->found;
    }
}

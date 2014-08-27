<?php

namespace Application\BDEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventCategory
 *
 * @ORM\Table(name="bde__event_category")
 * @ORM\Entity(repositoryClass="Application\BDEBundle\Repository\EventCategoryRepository")
 */
class EventCategory
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
     * @var string
     *
     * @ORM\Column(name="backgroundColor", type="string", length=255)
     */
    private $backgroundColor;

    /**
     * @var string
     *
     * @ORM\Column(name="textColor", type="string", length=255)
     */
    private $textColor;

    /**
     * @ORM\OneToMany(targetEntity="Application\BDEBundle\Entity\Event", mappedBy="category")
     */
    private $events;

    public function __toString() {
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
     * @return EventCategory
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
     * Set backgroundColor
     *
     * @param string $backgroundColor
     * @return EventCategory
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * Get backgroundColor
     *
     * @return string 
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * Set textColor
     *
     * @param string $textColor
     * @return EventCategory
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;

        return $this;
    }

    /**
     * Get textColor
     *
     * @return string 
     */
    public function getTextColor()
    {
        return $this->textColor;
    }
}

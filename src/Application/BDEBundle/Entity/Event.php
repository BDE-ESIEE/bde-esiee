<?php

namespace Application\BDEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Event
 *
 * @ORM\Table(name="bde__event")
 * @ORM\Entity(repositoryClass="Application\BDEBundle\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime")
     */
    private $dateEnd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;

    /**
     * @ORM\OneToMany(targetEntity="Application\Sonata\NewsBundle\Entity\Post", mappedBy="event")
     * @Exclude
     */
    private $news;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroundColor", type="string", length=255, nullable=true)
     */
    private $backgroundColor;

    /**
     * @var string
     *
     * @ORM\Column(name="textColor", type="string", length=255, nullable=true)
     */
    private $textColor;

    public function __toString()
    {
        return (null !== $this->title) ? $this->title : '';
    }

    public function __construct()
    {
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Event
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Event
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set private
     *
     * @param boolean $private
     * @return Event
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Event
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Add news
     *
     * @param \Application\Sonata\NewsBundle\Entity\Post $news
     * @return Event
     */
    public function addNews(\Application\Sonata\NewsBundle\Entity\Post $news)
    {
        $this->news[] = $news;

        return $this;
    }

    public function removeNews(\Application\Sonata\NewsBundle\Entity\Post $news)
    {
        $this->news->removeElevent($news);
    }

    /**
     * Get news
     *
     * @return \Application\Sonata\NewsBundle\Entity\Post 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set backgroundColor
     *
     * @param string $backgroundColor
     * @return Event
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
     * @return Event
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

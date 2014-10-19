<?php

namespace Application\BDEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Since;

/**
 * Club
 *
 * @ORM\Table(name="bde__club")
 * @ORM\Entity(repositoryClass="Application\BDEBundle\Repository\ClubRepository")
 * @ExclusionPolicy("none")
 */
class Club
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
     * @var string
     *
     * @ORM\Column(name="shortcode", type="string", length=255)
     */
    private $shortcode;

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     * @Exclude
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="abstract", type="text")
     */
    private $abstract;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="rawContent", type="text")
     * @Exclude
     */
    private $rawContent;

    /**
     * @var string
     *
     * @ORM\Column(name="contentFormatter", type="string", length=255)
     * @Exclude
     */
    private $contentFormatter;

    public $logoUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Application\BDEBundle\Entity\ClubCategory", inversedBy="clubs")
     * @ORM\JoinColumn(nullable=true)
     * @Exclude
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Since("1.1")
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Application\PoudlardBundle\Entity\ClubHasPoints", mappedBy="club")
     * @Exclude
     */
    private $points;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->points = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
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
     * @return Club
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
     * Set shortcode
     *
     * @param string $shortcode
     * @return Club
     */
    public function setShortcode($shortcode)
    {
        $this->shortcode = $shortcode;

        return $this;
    }

    /**
     * Get shortcode
     *
     * @return string 
     */
    public function getShortcode()
    {
        return $this->shortcode;
    }

    /**
     * Set logo
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $logo
     * @return Club
     */
    public function setLogo(\Application\Sonata\MediaBundle\Entity\Media $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return Application\Sonata\MediaBundle\Entity\Media
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Club
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set rawContent
     *
     * @param string $rawContent
     * @return Club
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * Get rawContent
     *
     * @return string 
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Set contentFormatter
     *
     * @param string $contentFormatter
     * @return Club
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;

        return $this;
    }

    /**
     * Get contentFormatter
     *
     * @return string 
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     * @return Club
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string 
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set category
     *
     * @param \Application\BDEBundle\Entity\ClubCategory $category
     * @return Club
     */
    public function setCategory(\Application\BDEBundle\Entity\ClubCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Application\BDEBundle\Entity\ClubCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get category id
     *
     * @return integer
     * @VirtualProperty
     */
    public function getCategoryId()
    {
        return $this->getCategory()->getId();
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Club
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add points
     *
     * @param \Application\PoudlardBundle\Entity\ClubHasPoints $points
     * @return Club
     */
    public function addPoint(\Application\PoudlardBundle\Entity\ClubHasPoints $points)
    {
        $this->points[] = $points;

        return $this;
    }

    /**
     * Remove points
     *
     * @param \Application\PoudlardBundle\Entity\ClubHasPoints $points
     */
    public function removePoint(\Application\PoudlardBundle\Entity\ClubHasPoints $points)
    {
        $this->points->removeElement($points);
    }

    /**
     * Get points
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPoints()
    {
        return $this->points;
    }

    public function getScore()
    {
        $total = 0;

        foreach($this->points as $clubHasPoints)
        {
            $total += $clubHasPoints->getAmount() + $clubHasPoints->getBonusMalus();
        }

        return $total;
    }
}

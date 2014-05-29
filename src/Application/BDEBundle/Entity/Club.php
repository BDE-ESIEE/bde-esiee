<?php

namespace Application\BDEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="Application\BDEBundle\Repository\ClubRepository")
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
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
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
     */
    private $rawContent;

    /**
     * @var string
     *
     * @ORM\Column(name="contentFormatter", type="string", length=255)
     */
    private $contentFormatter;


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
    public function setLogo(\Application\Sonata\MediaBundle\Entity\Media $logo)
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

    public function __toString()
    {
        return $this->title;
    }
}

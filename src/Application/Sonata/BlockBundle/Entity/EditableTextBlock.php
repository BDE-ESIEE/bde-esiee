<?php

namespace Application\Sonata\BlockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TextBlock
 *
 * @ORM\Table(name="bde__editable_text_block")
 * @ORM\Entity(repositoryClass="Application\Sonata\BlockBundle\Repository\EditableTextBlockRepository")
 */
class EditableTextBlock
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

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
     * @return TextBlock
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
     * Set content
     *
     * @param string $content
     * @return TextBlock
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
     * @return TextBlock
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
     * @return TextBlock
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
     * Set description
     *
     * @param string $description
     * @return EditableTextBlock
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

    public function __toString()
    {
        return ''.$this->title;
    }
}

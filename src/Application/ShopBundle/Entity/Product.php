<?php

namespace Application\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="shop__product")
 * @ORM\Entity(repositoryClass="Application\ShopBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="rawDescription", type="text")
     */
    private $rawDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionFormatter", type="string", length=255)
     */
    private $descriptionFormatter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden", type="boolean")
     */
    private $hidden;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enableCounter", type="boolean")
     */
    private $enableCounter;

    /**
     * @var integer
     *
     * @ORM\Column(name="counter", type="integer")
     */
    private $counter = 0;

    /**
     * @ORM\ManyToMany(targetEntity="Application\ShopBundle\Entity\Category", cascade={"persist"}, inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\JoinTable(name="shop__product_category")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\GalleryHasMedia", cascade={"all"})
     * @ORM\JoinTable(name="shop__product_media")
     */
    private $photos;

    /**
     * @var simple_array
     *
     * @ORM\Column(name="interestedPerson", type="simple_array", nullable=true)
     */
    private $interestedPerson;

    public function __toString()
    {
        return $this->name;
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
     * @return Product
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
     * Add photos
     *
     * @param \Application\Sonata\MediaBundle\Entity\GalleryHasMedia $photos
     * @return Product
     */
    public function addPhoto(\Application\Sonata\MediaBundle\Entity\GalleryHasMedia $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Application\Sonata\MediaBundle\Entity\GalleryHasMedia $photos
     */
    public function removePhoto(\Application\Sonata\MediaBundle\Entity\GalleryHasMedia $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categories
     *
     * @param \Application\ShopBundle\Entity\Category $categories
     * @return Product
     */
    public function addCategory(\Application\ShopBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Application\ShopBundle\Entity\Category $categories
     */
    public function removeCategory(\Application\ShopBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Set hidden
     *
     * @param boolean $hidden
     * @return Product
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean 
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set enableCounter
     *
     * @param boolean $enableCounter
     * @return Product
     */
    public function setEnableCounter($enableCounter)
    {
        $this->enableCounter = $enableCounter;

        return $this;
    }

    /**
     * Get enableCounter
     *
     * @return boolean 
     */
    public function getEnableCounter()
    {
        return $this->enableCounter;
    }

    /**
     * Set counter
     *
     * @param integer $counter
     * @return Product
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * Increment counter
     *
     * @return Product
     */
    public function incrementCounter()
    {
        $this->counter++;

        return $this;
    }

    /**
     * Get counter
     *
     * @return integer 
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * Set interestedPerson
     *
     * @param array $interestedPerson
     * @return Product
     */
    public function setInterestedPerson($interestedPerson)
    {
        $this->interestedPerson = $interestedPerson;

        return $this;
    }

    /**
     * Get interestedPerson
     *
     * @return array 
     */
    public function getInterestedPerson()
    {
        return $this->interestedPerson;
    }

    /**
     * Set rawDescription
     *
     * @param string $rawDescription
     * @return Product
     */
    public function setRawDescription($rawDescription)
    {
        $this->rawDescription = $rawDescription;

        return $this;
    }

    /**
     * Get rawDescription
     *
     * @return string 
     */
    public function getRawDescription()
    {
        return $this->rawDescription;
    }

    /**
     * Set descriptionFormatter
     *
     * @param string $descriptionFormatter
     * @return Product
     */
    public function setDescriptionFormatter($descriptionFormatter)
    {
        $this->descriptionFormatter = $descriptionFormatter;

        return $this;
    }

    /**
     * Get descriptionFormatter
     *
     * @return string 
     */
    public function getDescriptionFormatter()
    {
        return $this->descriptionFormatter;
    }
}

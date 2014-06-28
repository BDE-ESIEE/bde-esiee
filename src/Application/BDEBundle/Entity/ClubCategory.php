<?php

namespace Application\BDEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClubCategory
 *
 * @ORM\Table(name="bde__club_category")
 * @ORM\Entity(repositoryClass="Application\BDEBundle\Repository\ClubCategoryRepository")
 */
class ClubCategory
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
     * @ORM\OneToMany(targetEntity="Application\BDEBundle\Entity\Club", mappedBy="category")
     */
    private $clubs;

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
     * @return ClubCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->clubs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add clubs
     *
     * @param \Application\BDEBundle\Entity\Club $clubs
     * @return ClubCategory
     */
    public function addClub(\Application\BDEBundle\Entity\Club $clubs)
    {
        $this->clubs[] = $clubs;

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
}

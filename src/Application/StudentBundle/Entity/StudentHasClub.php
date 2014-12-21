<?php

namespace Application\StudentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudentHasClub
 */
class StudentHasClub
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $job;

    /**
     * @var \Application\StudentBundle\Entity\Student
     */
    private $student;

    /**
     * @var integer
     */
    private $phone;

    /**
     * @var integer
     */
    private $position = 0;

    /**
     * @var \Application\BDEBundle\Entity\Club
     */
    private $club_director;

    /**
     * @var \Application\BDEBundle\Entity\Club
     */
    private $club_member;

    public function __toString()
    {
        return ''.(null !== $this->job ? $this->job.' : ' : '').$this->student;
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
     * Set job
     *
     * @param string $job
     * @return StudentHasClub
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set student
     *
     * @param \Application\StudentBundle\Entity\Student $student
     * @return StudentHasClub
     */
    public function setStudent(\Application\StudentBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Application\StudentBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return StudentHasClub
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return StudentHasClub
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set club_director
     *
     * @param \Application\BDEBundle\Entity\Club $clubDirector
     * @return StudentHasClub
     */
    public function setClubDirector(\Application\BDEBundle\Entity\Club $clubDirector = null)
    {
        $this->club_director = $clubDirector;

        return $this;
    }

    /**
     * Get club_director
     *
     * @return \Application\BDEBundle\Entity\Club 
     */
    public function getClubDirector()
    {
        return $this->club_director;
    }

    /**
     * Set club_member
     *
     * @param \Application\BDEBundle\Entity\Club $clubMember
     * @return StudentHasClub
     */
    public function setClubMember(\Application\BDEBundle\Entity\Club $clubMember = null)
    {
        $this->club_member = $clubMember;

        return $this;
    }

    /**
     * Get club_member
     *
     * @return \Application\BDEBundle\Entity\Club 
     */
    public function getClubMember()
    {
        return $this->club_member;
    }
}

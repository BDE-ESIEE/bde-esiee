<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\BaseCollection as BaseCollection;

class Collection extends BaseCollection
{
    /**
     * @var integer $id
     */
    protected $id;

    private $cssClass;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getCssClass()
    {
        return $this->cssClass;
    }

    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }
}
<?php

namespace Application\BDEBundle\Twig;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;

/**
 * @Service
 * @Tag("twig.extension")
 */
class SortByFilter extends \Twig_Extension
{
	private $key = '';
	private $type = '';

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sortBy', array($this, 'sortByFilter')),
        );
    }

    public function sortByFilter($array, $key, $type)
    {
    	$this->key = $key;
    	$this->type = $type;

    	$array = $array->toArray();

    	//var_dump($array);
        
        usort($array, array($this, 'compare'));

        return $array;
    }

    private function compare($a, $b)
    {
    	$getter = 'get'.ucfirst($this->key);
    	if ($this->type == "numeric")
    	{
		    if ($a->$getter() == $b->$getter())
		        return 0;
		    return ($a->$getter() < $b->$getter()) ? -1 : 1;
    	}
    	else if ($this->type == "string")
    	{
    		return strcasecmp($a->$getter(), $b->$getter());
    	}
    }

    public function getName()
    {
        return 'application_bde_sortby';
    }
}
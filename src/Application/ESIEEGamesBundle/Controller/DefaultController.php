<?php

namespace Application\ESIEEGamesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @Template
     */
    public function indexAction()
    {
    	$list = $this->em->getRepository('ApplicationBDEBundle:Club')->findAllClubsWithPoint();
    	$clubs = array();

    	foreach ($list as $club) {
    		$club[0]->points = intval($club['points']);
    		$clubs[] = $club[0];
    	}

        return array(
        	'clubs' => $clubs,
        );
	}

}

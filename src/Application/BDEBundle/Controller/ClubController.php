<?php

namespace Application\BDEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\BDEBundle\Entity\Club;

class ClubController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ApplicationBDEBundle:Club');

    	$club_list = $repository->findBy(array(), array('title' => 'ASC'));

        return $this->render('ApplicationBDEBundle:Club:index.html.twig', array(
        	'club_list'	=> $club_list,
        ));
    }

    public function showAction(Club $club, $shortcode)
    {
        if ($shortcode != $club->getShortcode())
        {
            return $this->redirect($this->generateUrl('application_bde_club_show', array('id' => $club->getId(), 'shortcode' => $club->getShortcode())), 301);
        }

        return $this->render('ApplicationBDEBundle:Club:show.html.twig', array(
            'club' => $club,
        ));
    }
}

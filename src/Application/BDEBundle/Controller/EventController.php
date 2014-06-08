<?php

namespace Application\BDEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ApplicationBDEBundle:Event');

    	$event_list = $repository->findBy(array(), array('dateStart' => 'ASC'));
    	$event_json = array();

    	foreach ($event_list as $event) {
    		$event_json[] = array(
				'title'  => $event->getTitle(),
				'start'  => $event->getDateStart()->format('Y-m-d H:i:s'),
				'end'    => $event->getDateEnd()->format('Y-m-d H:i:s'),
				'allDay' => /*$event->getDateEnd()->diff($event->getDateStart())->h > 4*/ false,
                'place'  => $event->getPlace(),
    		);
    	}

        return $this->render('ApplicationBDEBundle:Event:index.html.twig', array(
        	'event_json' => json_encode($event_json),
        ));
    }
}

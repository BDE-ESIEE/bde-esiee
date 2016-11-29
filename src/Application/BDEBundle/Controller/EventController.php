<?php

namespace Application\BDEBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Common\Collections\Criteria;

class EventController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Retrieves the list of events",
     *  resource=true,
     *  output={"class"="Application\BDEBundle\Entity\Event"},
     *  statusCodes={
     *      200="Returned when successful"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
    public function indexAction($_format)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ApplicationBDEBundle:Event');

        $oneMonthAgo = new \DateTime('-1 month');

        $criteria = new Criteria();
        $criteria
            ->where($criteria->expr()->gt('dateStart', $oneMonthAgo))
            ->orderBy(array("dateStart" => Criteria::ASC))
        ;

        if ( !($_format != 'html' || $this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) ) {
            $criteria->andWhere($criteria->expr()->eq('private', false));
        }

    	$event_list = $repository->matching($criteria);
    	$event_json = array();

    	foreach ($event_list as $event) {
            $list_news = array();
            if (!$event->getNews()->isEmpty()) {
                foreach ($event->getNews() as $news) {
                    $list_news[] = $news->getId();
                }
            }
    		$event_json[] = array(
                'id'        => $event->getId(),
                'title'     => $event->getTitle(),
                'start'     => $event->getDateStart()->format('Y-m-d H:i:s'),
                'end'       => $event->getDateEnd()->format('Y-m-d H:i:s'),
                'allDay'    => /*$event->getDateEnd()->diff($event->getDateStart())->h > 4*/ false,
                'place'     => $event->getPlace(),
                'color'     => $event->getCategory()->getBackgroundColor(),
                'textColor' => $event->getCategory()->getTextColor(),
                'club_id'   => (null !== $event->getClub() ? $event->getClub()->getId() : null),
                'news_ids'  => $list_news,
    		);
    	}

        $view = $this->view($event_json, 200)
            ->setTemplate("ApplicationBDEBundle:Event:index.html.twig")
            ->setTemplateVar('events')
        ;

        return $this->handleView($view);
    }
}

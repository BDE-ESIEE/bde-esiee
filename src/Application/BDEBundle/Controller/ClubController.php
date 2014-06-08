<?php

namespace Application\BDEBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Application\BDEBundle\Entity\Club;

class ClubController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Retrieves the list of clubs",
     *  section="/clubs",
     *  output={"class"="Application\BDEBundle\Entity\Club"},
     *  statusCodes={
     *      200="Returned when successful"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ApplicationBDEBundle:Club');

    	$club_list = $repository->findBy(array(), array('title' => 'ASC'));

        $providers = array();
        foreach ($club_list as $key => $club) {
            if (!is_null($club->getLogo()))
            {
                $provider = $club->getLogo()->getProviderName();
                if (!in_array($provider, $providers))
                    $providers[$provider] = $this->get($provider);

                $club_list[$key]->logoUrl = $providers[$provider]->generatePublicUrl($club->getLogo(), 'default_big');
            }
        }

        $view = $this->view($club_list, 200)
            ->setTemplate("ApplicationBDEBundle:Club:index.html.twig")
            ->setTemplateVar('club_list')
        ;

        return $this->handleView($view);
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

    /**
     * @ApiDoc(
     *  requirements={
     *      {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="club id"}
     *  },
     *  description="Retrieves a specific club",
     *  section="/clubs",
     *  output={"class"="Application\BDEBundle\Entity\Club"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when club is not found"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
    public function getClubAction(Club $club)
    {
        $view = $this->view($club, 200)
            ->setTemplate("ApplicationBDEBundle:Club:show.html.twig")
            ->setTemplateVar('club')
        ;

        return $this->handleView($view);
    }
}

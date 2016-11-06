<?php

namespace Application\BDEBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Application\BDEBundle\Entity\Club;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

class ClubController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Retrieves the list of clubs sorted by category",
     *  resource=true,
     *  output={"class"="Application\BDEBundle\Entity\Club"},
     *  statusCodes={
     *      200="Returned when successful"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
    public function indexAction($_format)
    {
    	$em = $this->getDoctrine()->getManager();

    	$club_category_list = $em->getRepository('ApplicationBDEBundle:ClubCategory')->findAll();
        

        $club_list_by_category = array();

        foreach ($club_category_list as $club_category) {
            $club_list_by_category[$club_category->getName()] = $em->getRepository('ApplicationBDEBundle:Club')->findBy(array('category' => $club_category), array('title' => 'ASC'));
        }

        $providers = array();
        foreach ($club_list_by_category as $club_list) {
            foreach ($club_list as $key => $club) {
                if (!is_null($club->getLogo()))
                {
                    $provider = $club->getLogo()->getProviderName();
                    if (!in_array($provider, $providers))
                        $providers[$provider] = $this->get($provider);

                    $club_list[$key]->logoUrl = $providers[$provider]->generatePublicUrl($club->getLogo(), 'club_big');
                }
            }
        }

        if ($_format == 'html')
            $club_list_by_category = array('club_list_by_category' => $club_list_by_category);

        $view = $this->view($club_list_by_category, 200)
            ->setTemplate("ApplicationBDEBundle:Club:index.html.twig")
            ->setTemplateVar('club_list_by_category')
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

    public function getClubTrombiAction(Club $club, $_format, Request $request)
    {
        $mimetypes = array(
            'jpg' => 'image/jpg',
            'pdf' => 'application/pdf',
        );
        $renderer = array(
            'jpg' => 'knp_snappy.image',
            'pdf' => 'knp_snappy.pdf',
        );

        // return $this->render('ApplicationBDEBundle:Club:trombi_exporter.html.twig', array(
        //     'club' => $club,
        // ));

        $club->sortMembers();

        $html = $this->renderView('ApplicationBDEBundle:Club:trombi_exporter.html.twig', array(
            'club'            => $club,
            'contributorOnly' => (bool) $request->query->get('contributorOnly', false),
        ));

        return new Response(
            $this->get($renderer[$_format])->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'        => $mimetypes[$_format],
                'Content-Disposition' => 'attachment; filename="trombi-'.$club->getTitle().'-'.(new \DateTime())->format('M Y').'.'.$_format.'"',
            )
        );
    }

    public function feesRefundAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $clubs      = $em->getRepository('ApplicationBDEBundle:Club')->findAll();
        $serializer = $this->get('jms_serializer');
        $clubsById  = array();
        foreach ($clubs as $club) {
            $clubsById[$club->getId()] = $club;
        }
        $json       = $serializer->serialize($clubsById, 'json', SerializationContext::create()->setGroups(array('fees')));

        $form = $this->createFormBuilder()
            ->add('name', 'student', array(
                'label' => false
            ))
            ->getForm();

        return $this->render('ApplicationBDEBundle:Club:fees_refund.html.twig', array(
            'clubs' => $json,
            'form'  => $form->createView()
        ));
    }
}

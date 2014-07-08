<?php

namespace Application\BDEBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

class LostPropertyController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Retrieves the list of lost properties",
     *  output={"class"="Application\BDEBundle\Entity\LostProperty"},
     *  statusCodes={
     *      200="Returned when successful"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
    public function indexAction()
    {
        $lost_property_list = $this->getDoctrine()->getManager()->getRepository('ApplicationBDEBundle:LostProperty')->findAll();

        $view = $this->view($lost_property_list, 200)
            ->setTemplate("ApplicationBDEBundle:LostProperty:index.html.twig")
            ->setTemplateVar('lost_property_list')
        ;

        return $this->handleView($view);
    }
}

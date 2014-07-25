<?php

namespace Application\BDEBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

class BargainController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Retrieves the list of bargains",
     *  output={"class"="Application\BDEBundle\Entity\Bargain"},
     *  statusCodes={
     *      200="Returned when successful"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
    public function indexAction()
    {
        $bargain_list = $this->getDoctrine()->getManager()->getRepository('ApplicationBDEBundle:Bargain')->findAll();

        $view = $this->view($bargain_list, 200)
            ->setTemplate('ApplicationBDEBundle:Bargain:index.html.twig')
            ->setTemplateVar('bargain_list')
        ;

        return $this->handleView($view);
    }
}

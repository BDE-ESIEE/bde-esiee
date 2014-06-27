<?php

namespace Application\Sonata\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArchiveController extends Controller
{
    public function sideMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tag_list = $em->getRepository('ApplicationSonataClassificationBundle:Tag')->findBy(array('enabled' => true));
        $cat_list = $em->getRepository('ApplicationSonataClassificationBundle:Collection')->findBy(array('enabled' => true));

        return $this->render('ApplicationSonataNewsBundle:Post:sideMenu.html.twig', array(
            'tag_list' => $tag_list,
            'cat_list' => $cat_list,
        ));
    }
}
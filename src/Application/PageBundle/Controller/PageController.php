<?php

namespace Application\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function historyAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function associationAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function cotisationAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function partnershipAction()
    {
        return array();
    }

    public function eatTrafficAction()
    {
        return $this->render('ApplicationPageBundle:Page:eat_traffic.html.twig');
    }

    /**
     * @Template
     */
    public function aboutusAction()
    {
        return array();
    }
}

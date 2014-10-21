<?php

namespace Application\BDEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
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
        return $this->render('ApplicationBDEBundle:Default:eat_traffic.html.twig');
    }

    public function goodPlanAction()
    {
        return $this->render('ApplicationBDEBundle:Default:good_plan.html.twig');
    }

    /**
     * @Template
     */
    public function aboutusAction()
    {
        return array();
    }
}

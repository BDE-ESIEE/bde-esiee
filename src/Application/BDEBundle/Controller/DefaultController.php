<?php

namespace Application\BDEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApplicationBDEBundle:Default:index.html.twig');
    }

    public function historyAction()
    {
    	return $this->render('ApplicationBDEBundle:Default:history.html.twig');
    }

    public function partnershipAction()
    {
    	return $this->render('ApplicationBDEBundle:Default:partnership.html.twig');
    }

    public function eatTrafficAction()
    {
        return $this->render('ApplicationBDEBundle:Default:eat_traffic.html.twig');
    }

    public function goodPlanAction()
    {
        return $this->render('ApplicationBDEBundle:Default:good_plan.html.twig');
    }

    public function aboutusAction()
    {
        return $this->render('ApplicationBDEBundle:Default:aboutus.html.twig');
    }
}

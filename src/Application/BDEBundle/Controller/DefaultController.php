<?php

namespace Application\BDEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApplicationBDEBundle:Default:index.html.twig');
    }

    public function teamAction()
    {
    	return $this->render('ApplicationBDEBundle:Default:team.html.twig');
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
}

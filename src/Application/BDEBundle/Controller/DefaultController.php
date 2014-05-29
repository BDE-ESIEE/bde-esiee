<?php

namespace Application\BDEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApplicationBDEBundle:Default:index.html.twig');
    }
}

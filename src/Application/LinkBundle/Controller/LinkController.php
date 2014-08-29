<?php

namespace Application\LinkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\LinkBundle\Entity\Link;

class LinkController extends Controller
{
    public function redirectAction(Link $link)
    {
        return $this->redirect($link->getUrl());
    }
}

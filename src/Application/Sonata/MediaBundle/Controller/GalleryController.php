<?php

namespace Application\Sonata\MediaBundle\Controller;

use Sonata\MediaBundle\Controller\GalleryController as BaseController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GalleryController extends BaseController
{
    /**
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function indexAction()
    {
        $galleries = $this->get('sonata.media.manager.gallery')->findBy(array(
            'enabled' => true,
            'context' => 'gallery',
        ));

        return $this->render('SonataMediaBundle:Gallery:index.html.twig', array(
            'galleries'   => $galleries,
        ));
    }
}

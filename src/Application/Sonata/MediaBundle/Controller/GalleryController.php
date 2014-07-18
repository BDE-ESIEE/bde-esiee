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

    /**
     * @param string $id
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function viewAction($id)
    {
        $gallery = $this->get('sonata.media.manager.gallery')->findOneBy(array(
            'id'      => $id,
            'enabled' => true
        ));

        if (!$gallery) {
            throw new NotFoundHttpException('Impossible de trouver une galerie avec cet id');
        }

        $youtube = false;
        foreach ($gallery->getGalleryHasMedias() as $galleryHasMedia) {
            if ($galleryHasMedia->getMedia()->getProviderName() == 'sonata.media.provider.youtube' || $galleryHasMedia->getMedia()->getProviderName() == 'sonata.media.provider.dailymotion')
                $youtube = true;
        }

        return $this->render('SonataMediaBundle:Gallery:view.html.twig', array(
            'gallery'   => $gallery,
            'youtube'   => $youtube,
        ));
    }
}

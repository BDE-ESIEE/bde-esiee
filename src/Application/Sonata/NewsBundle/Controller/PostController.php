<?php

namespace Application\Sonata\NewsBundle\Controller;

use Sonata\NewsBundle\Controller\PostController as BaseController;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sonata\NewsBundle\Model\CommentInterface;
use Sonata\NewsBundle\Model\PostInterface;

class PostController extends BaseController
{
    /**
     * @param array $criteria
     * @param array $parameters
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderArchive(array $criteria = array(), array $parameters = array(), Request $request = null)
    {
        $pager = $this->getPostManager()->getPager(
            $criteria,
            $this->getRequest()->get('page', 1)
        );

        $pager->setMaxPerPage(4);
        $pager->setPage($this->getRequest()->get('page', 1));
        $pager->getQuery()->setMaxResults(null);
        $pager->getQuery()->setFirstResult(null);
        $pager->getQuery()->setSortBy(array(), array('fieldName'=>'publicationDateStart'));
        $pager->init();

        $parameters = array_merge(array(
            'pager'            => $pager,
            'blog'             => $this->getBlog(),
            'tag'              => false,
            'collection'       => false,
            'route'            => $this->getRequest()->get('_route'),
            'route_parameters' => $this->getRequest()->get('_route_params')
        ), $parameters);

        $response = $this->render(sprintf('SonataNewsBundle:Post:archive.%s.twig', $this->getRequest()->getRequestFormat()), $parameters);

        if ('rss' === $this->getRequest()->getRequestFormat()) {
            $response->headers->set('Content-Type', 'application/rss+xml');
        }

        return $response;
    }

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

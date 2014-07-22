<?php

namespace Application\Sonata\BlockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

class EditableTextBlockController extends Controller
{
    /**
     * @Secure(roles="ROLE_EDITOR")
     */
    public function ajaxUpdateAction()
    {
        $request = $this->get('request');
        $title = $request->request->get('title', null);
        $html = $request->request->get('html', null);

        if (null === $title || null === $html)
        {
            return new Response('Fail');
        } 

        $em = $this->getDoctrine()->getManager();

        $block = $em->getRepository('ApplicationSonataBlockBundle:EditableTextBlock')->findOneByTitle($title);

        $block->setContent($html);
        $block->setRawContent($html);

        $em->persist($block);
        $em->flush();

        return new Response('Perfect');
    }
}

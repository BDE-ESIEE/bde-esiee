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

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (empty($title) || empty($html))
        {
            $response->setContent(json_encode(false));
        } 

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ApplicationSonataBlockBundle:EditableTextBlock');
        $errors = array();

        for ($i = 0; $i < count($title); $i++)
        {
            $block = $repo->findOneByTitle($title[$i]);

            $errors[$i] = !(null === $block);
            if (null === $block)
                continue;

            $block->setContent($html[$i]);
            $block->setRawContent($html[$i]);

            $em->persist($block);
        }

        $em->flush();

        $response->setContent(json_encode($errors));

        return $response;
    }
}

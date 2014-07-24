<?php

namespace Application\Sonata\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentController extends Controller
{
    public function renderThreadAction($id, $url)
    {
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($url);

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);

        return $this->render('ApplicationSonataCommentBundle:Thread:renderThread.html.twig', array(
            'comments' => $comments,
            'thread'   => $thread,
        ));
    }
}

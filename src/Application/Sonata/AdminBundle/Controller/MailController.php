<?php

namespace Application\Sonata\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Sonata\AdminBundle\Form\SendMailType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

class MailController extends Controller
{
	public function sortDate($a, $b)
	{
		$dateA = new \DateTime($a);
		$dateB = new \DateTime($b);
		$diff = $dateB->diff($dateA);
		return intval($diff->format('%R%a'));
	}

    /**
     * @Secure(roles="ROLE_COMMUNICATION")
     */
    public function sendMailAction()
    {

    	$post_list = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('ApplicationSonataNewsBundle:Post')
                      ->findBy(
                      	array(), 
                      	array('publicationDateStart' => 'DESC')
                      );

		$form = $this->createForm(new SendMailType(), null, array(
		    'action' => $this->generateUrl('application_sonata_admin_send_mail'),
		    'method' => 'POST',
		));

		$request = $this->get('request');
		$posts = null;
		$intro = null;
		$important = null;
		$mail = null;
		$bind = false;
		$week = array();
		$afterWeek = array();
		$other = array();
		$mailName = null;
		$now = new \DateTime();
		$oneWeek = (new \DateTime())->modify('+1 week');

		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			$bind = true;

			if ($form->isValid()) {
				$posts = $form->get('news')->getData();
				$intro = $form->get('intro')->getData();
				$important = $form->get('important')->getData();
				$mail = $form->get('email')->getData();
				$mailName = 'mail/mail-hebdo-'.(new \DateTime())->format('d-m-Y-H:i:s').'.html';

				foreach ($posts as $post) {
					if (null !== $post->getEvent()) {
						if ($post->getEvent()->getDateStart() < $oneWeek)
							$week[$post->getEvent()->getDateStart()->format('Y-m-d')][] = $post;
						else
							$afterWeek[$post->getEvent()->getDateStart()->format('Y-m-d')][] = $post;
					}
					else {
						$other[] = $post;
					}
				}

				uksort($week, array($this, "sortDate"));
				uksort($afterWeek, array($this, "sortDate"));

				if ($form->get('aperçu')->isClicked())
				{
					$posts = $form->get('news')->getData();
					$intro = $form->get('intro')->getData();
					$mail = $form->get('email')->getData();
				} elseif ($form->get('envoyer')->isClicked()) {
					file_put_contents($mailName, $this->renderView(
		                'ApplicationSonataAdminBundle:Mail:newsletter.html.twig', array(
							'posts'     => $posts,
							'intro'     => $intro,
							'important' => $important,
							'week'      => $week,
							'afterWeek' => $afterWeek,
							'other'     => $other,
							'mailName'  => $mailName,
		                )));

			        $swiftMessage = \Swift_Message::newInstance()
			            ->setSubject('N\'OUBLIE PAS DE MODIFIER LE SUJET :p (et d\'enlever le TR)')
			            ->setFrom('bde@edu.esiee.fr')
			            ->setTo($mail)
			            ->setBody($this->renderView(
			                'ApplicationSonataAdminBundle:Mail:newsletter.html.twig', array(
								'posts'     => $posts,
								'intro'     => $intro,
								'important' => $important,
								'week'      => $week,
								'afterWeek' => $afterWeek,
								'other'     => $other,
								'mailName'  => $mailName,
			                )),
			                'text/html'
			            )
			        ;
			        $this->get('mailer')->send($swiftMessage);

					$this->get('session')
		            	 ->getFlashBag()
		            	 ->add('sonata_flash_success', 'Le mail a bien été envoyé.');
				}
			}
		}

		if (!$bind && $post_list !== null)
		{
			// On préselectionne les news
			$checked = array();
			foreach($post_list as $post) {
				if ((null !== $post->getEvent() && $post->getEvent()->getDateStart() >= $now && $post->getEvent()->getDateStart() <= $oneWeek) || ($post->getPublicationDateStart() >= $now && $post->getPublicationDateStart() <= $oneWeek))
					$checked[] = $post;
			}
			$form->get('news')->setData($checked);
		}

		return $this->render('ApplicationSonataAdminBundle:Admin:mail.html.twig', array(
			'admin_pool' => $this->container->get('sonata.admin.pool'),
			'form'       => $form->createView(),
			'posts'      => $posts,
			'intro'      => $intro,
			'important'  => $important,
			'mail'       => $mail,
			'week'       => $week,
			'afterWeek'  => $afterWeek,
			'other'      => $other,
			'mailName'   => $mailName,
        ));
    }
}

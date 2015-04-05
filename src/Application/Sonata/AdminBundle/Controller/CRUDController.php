<?php

namespace Application\Sonata\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sonata\AdminBundle\Exception\ModelManagerException;

class CRUDController extends BaseController
{
	/**
	 * {@InheritDoc}
	 */
	protected function getAclUsers()
	{
	    $em = $this->container->get('doctrine.orm.entity_manager');

	    // Display only users in groups
	    $groups = $em->getRepository('ApplicationSonataUserBundle:Group')->findAll();
	    $users = array();

	    foreach ($groups as $group) {
	    	$users = array_merge($users, $group->getUsers()->getValues());
	    }

	    return new \ArrayIterator($users);
	}

	public function trombiAction()
	{
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        return $this->render($this->admin->getTemplate('trombi'), array(
			'action' => 'trombi',
			'object' => $object,
        ));
	}

	public function statsAction()
	{
        if (!$this->admin->isGranted('MASTER')) {
			throw new AccessDeniedException();
        }
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        return $this->render($this->admin->getTemplate('stats'), array(
			'action' => 'stats',
			'object' => $object,
        ));
	}

	/**
	 * Create action
	 *
	 * @return Response
	 *
	 * @throws AccessDeniedException If access is not granted
	 */
	public function createAction()
	{
		// the key used to lookup the template
		$templateKey = 'edit';

		if (false === $this->admin->isGranted('CREATE')) {
			throw new AccessDeniedException();
		}

		$object = $this->admin->getNewInstance();

		$this->admin->setSubject($object);

		/** @var $form \Symfony\Component\Form\Form */
		$form = $this->admin->getForm();
		$form->setData($object);

		if ($this->getRestMethod()== 'POST') {
			$form->submit($this->get('request'));

			$isFormValid = $form->isValid();

			// persist if the form was valid and if in preview mode the preview was approved
			if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

				if (false === $this->admin->isGranted('CREATE')) {
					throw new AccessDeniedException();
				}

				try {
					$object = $this->admin->create($object);

					if ($this->isXmlHttpRequest()) {
						return $this->renderJson(array(
							'result' => 'ok',
							'objectId' => $this->admin->getNormalizedIdentifier($object)
						));
					}

					$this->addFlash(
						'sonata_flash_success',
						$this->admin->trans(
							'flash_create_success',
							array('%name%' => $this->escapeHtml($this->admin->toString($object))),
							'SonataAdminBundle'
						)
					);

					// redirect to edit mode
					return $this->redirectTo($object);

				} catch (ModelManagerException $e) {
					$this->handleModelManagerException($e);

					$isFormValid = false;
				}
			}

			// show an error message if the form failed validation
			if (!$isFormValid) {
				if (!$this->isXmlHttpRequest()) {
					$this->addFlash(
						'sonata_flash_error',
						$this->admin->trans(
							'flash_create_error',
							array('%name%' => $this->escapeHtml($this->admin->toString($object))),
							'SonataAdminBundle'
						)
					);
				}
			} elseif ($this->isPreviewRequested()) {
				// pick the preview template if the form was valid and preview was requested
				$templateKey = 'preview';
				$this->admin->getShow();
			}
		}

		$view = $form->createView();

		// set the theme for the current Admin Form
		$this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

		return $this->render($this->admin->getTemplate($templateKey), array(
			'action' => 'create',
			'form'   => $view,
			'object' => $object,
		));
	}
}

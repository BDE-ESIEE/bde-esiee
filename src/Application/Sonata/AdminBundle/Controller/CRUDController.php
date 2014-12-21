<?php

namespace Application\Sonata\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;

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
}

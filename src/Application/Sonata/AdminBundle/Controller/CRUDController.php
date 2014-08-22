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
}

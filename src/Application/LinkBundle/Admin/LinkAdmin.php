<?php

namespace Application\LinkBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Routing\Router;

class LinkAdmin extends Admin
{
    protected $router;

    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('token')
            ->add('url')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('token')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('url')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $subject = $showMapper->getAdmin()->getSubject();
        $subject->setGeneratedUrl($this->router->generate('application_link_redirect', array('token' => $subject->getToken()), true));
        $showMapper
            ->add('id')
            ->add('token')
            ->add('url', 'url')
            ->add('generatedUrl', 'url')
        ;
    }
}

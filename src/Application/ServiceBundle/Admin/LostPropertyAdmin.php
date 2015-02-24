<?php

namespace Application\ServiceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LostPropertyAdmin extends Admin
{	
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('date')
            ->add('found', 'choice', array(
                'choices' => array('1' => 'Trouvé', '0' => 'Perdu'),
                'expanded' => true,
                'empty_value' => false,
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('date')
            ->add('found')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('date')
            ->add('found')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('date')
            ->add('found')
        ;
    }
}
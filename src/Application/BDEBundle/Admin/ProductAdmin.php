<?php

namespace Application\BDEBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\MediaBundle\Provider\Pool;

class ProductAdmin extends Admin
{	
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description', 'sonata_formatter_type', array(
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'   => 'descriptionFormatter',
                'source_field'   => 'rawDescription',
                'source_field_options'      => array(
                    'attr' => array('class' => 'span10', 'rows' => 20)
                ),
                'target_field'   => 'description',
                'listener'       => true,
            ))
            ->add('hidden', null, array('required' => false))
            ->add('enableCounter', null, array('required' => false))
            ->add('counter', null, array('required' => false))
            ->add('interestedPerson', 'collection', array('required' => false, 'allow_delete' => true))
            ->add('categories', 'sonata_type_model', array(
                'by_reference' => false,
                'btn_delete'   => false,
                'required'     => false,
                'multiple'     => true,
            ))
            ->add('photos', 'sonata_type_model_list', array(
                'btn_delete' => false,
                'required'   => false,
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('hidden')
            ->add('enableCounter')
            ->add('counter')
            ->add('interestedPerson')
            ->add('categories')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('hidden')
            ->add('enableCounter')
            ->add('categories')
            ->add('counter')
            ->addIdentifier('photos')
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('description', null, array('safe' => true))
            ->add('hidden')
            ->add('enableCounter')
            ->add('counter')
            ->add('interestedPerson', 'array')
            ->add('categories')
            ->add('photos')
        ;
    }
}
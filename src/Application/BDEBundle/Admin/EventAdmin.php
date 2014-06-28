<?php

namespace Application\BDEBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\MediaBundle\Provider\Pool;

class EventAdmin extends Admin
{	
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $formMapper->getAdmin()->getSubject();
        $formMapper
            ->add('title')
            ->add('dateStart', 'sonata_type_datetime_picker', array(
                'dp_language'    => 'fr',
                'date_format'    => "d.m.Y, H:i",
                'dp_use_seconds' => false,
                'dp_min_date'    => '1/1/'.(new \DateTime())->format("Y")
            ))
            ->add('dateEnd', 'sonata_type_datetime_picker', array(
                'dp_language'    => 'fr',
                'date_format'    => "d.m.Y, H:i",
                'dp_use_seconds' => false,
                'dp_min_date'    => '1/1/'.(new \DateTime())->format("Y")
            ))
            ->add('private', null, array('required' => false))
            ->add('place', null, array('required' => false))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('private')
            ->add('place')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('private')
            ->add('place')
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('private')
            ->add('place')
            ->add('news', null, array(
                'admin_code' => 'bde.admin.post'
            ))
        ;
    }
}
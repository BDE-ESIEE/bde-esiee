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
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $formMapper->getAdmin()->getSubject();
        $user    = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        if (null !== $user->getClub() && null === $subject->getClub())
            $subject->setClub($user->getClub());

        $formMapper
            ->add('title')
            ->add('dateStart', 'sonata_type_datetime_picker', array(
                'dp_language'    => 'fr',
                'date_format'    => "d MMM YYYY H:mm:ss",
                'dp_use_seconds' => false,
                'dp_min_date'    => '1/1/'.(new \DateTime())->format("Y")
            ))
            ->add('dateEnd', 'sonata_type_datetime_picker', array(
                'dp_language'    => 'fr',
                'date_format'    => "d MMM YYYY H:mm:ss",
                'dp_use_seconds' => false,
                'dp_min_date'    => '1/1/'.(new \DateTime())->format("Y")
            ))
            ->add('private', null, array('required' => false))
            ->add('place', null, array('required' => false))
            ->add('category', 'entity', array(
                'expanded'   => true,
                'class'      => 'ApplicationBDEBundle:EventCategory',
                'data_class' => 'Application\BDEBundle\Entity\EventCategory'
            ))
            ->add('club', null, array(
                'required'    => true,
                'empty_value' => 'Choisissez un club'
            ))
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
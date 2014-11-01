<?php

namespace Application\PoudlardBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PointsAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('date')
            ->add('total')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('date', 'date')
            ->add('total', 'integer', array(
                'code' => 'getTotal',
                'mapped'    => false,
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show'   => array(),
                    'edit'   => array(),
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
            ->add('name')
            ->add('date', 'sonata_type_datetime_picker', array(
                'dp_language'    => 'fr',
                'date_format'    => "d.m.Y, H:i",
                'dp_use_seconds' => false,
                'dp_min_date'    => '1/1/'.(new \DateTime())->format("Y")
            ))
            ->add('distribution', 'sonata_type_collection', array(
                    'cascade_validation' => true,
                    'required'           => false,
                ), array(
                    'edit'              => 'inline',
                    'inline'            => 'table',
                    'admin_code'        => 'application_poudlard.admin.club_has_points'
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('date', 'date')
            ->add('total')
            ->add('distribution')
            ->add('distributionByHouse', null, array('safe' => true))
        ;
    }
}

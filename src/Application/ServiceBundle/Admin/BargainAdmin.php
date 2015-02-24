<?php

namespace Application\ServiceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BargainAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('logo')
            ->add('content', null, array('safe' => true))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('logo', 'sonata_media_type', array(
                'required'      => false,
                'provider'      => 'sonata.media.provider.image',
                'context'       => 'gallery',
                'new_on_update' => false,
            ))
            ->add('content', 'sonata_formatter_type', array(
                'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'         => 'contentFormatter',
                'source_field'         => 'rawContent',
                'source_field_options' => array(
                    'attr' => array('class' => 'span10', 'rows' => 20)
                ),
                'target_field'         => 'content',
                'listener'             => true,
                'ckeditor_context'     => 'main',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('logo')
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
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('content')
        ;
    }
}

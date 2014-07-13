<?php

namespace Application\BDEBundle\Admin;

use Sonata\NewsBundle\Admin\PostAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class PostAdmin extends BaseAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper->remove('content');

        $formMapper
            ->with('General')
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
                ->add('event', 'sonata_type_model_list', array(
                    'btn_delete' => false,
                    'required'   => false,
                    'label'      => 'Événement',
                ))
            ->end()
            ->with('Photo')
                ->add('photo', 'sonata_media_type', array(
                    'required'      => false,
                    'provider'      => 'sonata.media.provider.image',
                    'context'       => 'news',
                    'new_on_update' => false,
                    'label'         => 'Photo',
                ))
            ->end()
        ;
    }
}

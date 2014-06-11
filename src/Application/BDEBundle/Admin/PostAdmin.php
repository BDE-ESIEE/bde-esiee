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

        $formMapper
            ->with('General')
                ->add('event', 'sonata_type_model_list', array(
                    'btn_delete' => false,
                    'required'   => false,
                    'label'      => 'Événement',
                ))
            ->end()
        ;
    }
}

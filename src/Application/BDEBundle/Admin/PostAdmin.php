<?php

namespace Application\BDEBundle\Admin;

use Sonata\NewsBundle\Admin\PostAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class PostAdmin extends BaseAdmin
{
    public $supportsPreviewMode = true;

    public function getTemplate($name)
    {
        switch ($name) {
            case 'preview':
                return 'ApplicationSonataNewsBundle:Post:preview.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper->remove('content');
        $formMapper->remove('author');
        $formMapper->remove('enabled');

        if ($this->isGranted('EDITOR'))
        {
            $formMapper
                ->with('General')
                    ->add('author', 'sonata_type_model_list')
                    ->add('enabled', null, array('required' => false))
                ->end()
            ;
        }

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

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        parent::prePersist($object);

        if (!$this->isGranted('EDITOR'))
        {
            $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
            $object->setAuthor($user);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper->remove('commentsCount');

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
                'label' => 'Actions'
            ))
        ;
    }
}

<?php

namespace Application\BDEBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Formatter\Pool as FormatterPool;
use Sonata\CoreBundle\Model\ManagerInterface;

use Knp\Menu\ItemInterface as MenuItemInterface;

class ClubAdmin extends Admin
{
    public $supportsPreviewMode = true;

    public function getTemplate($name)
    {
        switch ($name) {
            case 'preview':
                return 'ApplicationBDEBundle:Club:preview.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('shortcode')
            ->add('logo')
            ->add('abstract')
            ->add('content', null, array('safe' => true))
            ->add('category')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('shortcode')
            ->add('category')
            ->add('logo', 'sonata_media_type', array(
                'required'      => false,
                'provider'      => 'sonata.media.provider.image',
                'context'       => 'club',
                'new_on_update' => false,
            ))
            ->add('abstract', null, array('attr' => array('class' => 'span6', 'rows' => 5)))
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
            ->add('shortcode')
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
        $that = $this;

        $datagridMapper
            ->add('title')
            ->add('shortcode')
            ->add('category')
        ;
    }
}

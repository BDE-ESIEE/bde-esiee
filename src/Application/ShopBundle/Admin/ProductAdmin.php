<?php

namespace Application\ShopBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Model\Metadata;

class ProductAdmin extends Admin
{	
    public $supportsPreviewMode = true;

    public function getTemplate($name)
    {
        switch ($name) {
            case 'preview':
                return 'ApplicationShopBundle:Shop:preview.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description', 'sonata_formatter_type', array(
                'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'         => 'descriptionFormatter',
                'source_field'         => 'rawDescription',
                'source_field_options' => array(
                    'attr' => array('class' => 'span10', 'rows' => 20)
                ),
                'target_field'         => 'description',
                'listener'             => true,
                'ckeditor_context'     => 'main',
            ))
            ->add('hidden', null, array('required' => false))
            ->add('enableCounter', null, array('required' => false))
            ->add('counter', null, array('required' => false))
            ->add('price', null, array('required' => false))
            ->add('interestedPerson', 'collection', array('required' => false, 'allow_delete' => true))
            ->add('categories', 'sonata_type_model', array(
                'by_reference' => false,
                'btn_delete'   => false,
                'required'     => false,
                'multiple'     => true,
            ))
            ->add('photos', 'sonata_type_collection', array(
                    'cascade_validation' => true,
                    'required'   => false,
                ), array(
                    'edit'              => 'inline',
                    'inline'            => 'table',
                    'link_parameters'   => array('context' => 'shop'),
                    'admin_code'        => 'sonata.media.admin.gallery_has_media'
                )
            )
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('price')
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
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('description', null, array('safe' => true))
            ->add('price')
            ->add('hidden')
            ->add('enableCounter')
            ->add('counter')
            ->add('interestedPerson', 'array')
            ->add('categories')
            ->add('photos')
        ;
    }

    public function getObjectMetadata($object)
    {
        $url = null;
        if ($object->getPhotos()->count() > 0)
        {
            $media = $object->getPhotos()->first()->getMedia();
            $provider = $this->getConfigurationPool()->getContainer()->get($media->getProviderName());

            $url = $provider->generatePublicUrl($media, 'shop_big');
        }
        return new Metadata($this->toString($object), null, $url);
    }
}
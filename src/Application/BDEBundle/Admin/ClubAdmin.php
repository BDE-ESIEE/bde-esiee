<?php

namespace Application\BDEBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Model\Metadata;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class ClubAdmin extends Admin
{
    public $supportsPreviewMode = true;

    public function getTemplate($name)
    {
        switch ($name) {
            case 'preview':
                return 'ApplicationBDEBundle:Club:preview.html.twig';
                break;
            case 'trombi':
                return 'ApplicationBDEBundle:Club:trombi.html.twig';
                break;
            case 'stats':
                return 'ApplicationBDEBundle:Admin:show_stats.html.twig';
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
            ->add('email')
            ->add('logo')
            ->add('abstract')
            ->add('content', null, array('safe' => true))
            ->add('category')
            ->add('directors')
            ->add('members')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->getSubject()->sortMembers();
        
        $formMapper
            ->with('Informations')
                ->add('title')
                ->add('shortcode')
                ->add('email', null, array(
                    'required'      => false,
                ))
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
            ->end()
            ->with('Membres')
                ->add('directors', 'sonata_type_collection', array(
                        'cascade_validation' => true,
                        'required'           => false,
                    ), array(
                        'edit'       => 'inline',
                        'inline'     => 'table',
                        'sortable'   => 'position',
                        'admin_code' => 'application_student.admin.student_has_club',
                        'has_job'    => true,
                    )
                )
                ->add('members', 'sonata_type_collection', array(
                        'cascade_validation' => true,
                        'required'           => false,
                    ), array(
                        'edit'       => 'inline',
                        'inline'     => 'table',
                        'admin_code' => 'application_student.admin.student_has_club',
                        'has_job'    => false,
                    )
                )
            ->end()
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
            ->add('email')
            ->add('shortcode')
            ->add('category')
        ;
    }

    public function prePersist($object)
    {
        foreach ($object->getMembers() as $member) {
            $member->setClubMember($object);
        }
        foreach ($object->getDirectors() as $director) {
            $director->setClubDirector($object);
        }
    }

    public function preUpdate($object)
    {
        foreach ($object->getMembers() as $member) {
            $member->setClubMember($object);
        }
        foreach ($object->getDirectors() as $director) {
            $director->setClubDirector($object);
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('trombi', $this->getRouterIdParameter().'/trombi');
        $collection->add('stats', $this->getRouterIdParameter().'/stats');
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit', 'show', 'history'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            'Trombi',
            array('uri' => $admin->generateUrl('trombi', array('id' => $id)))
        );

        if ($this->isGranted('MASTER')) {
            $menu->addChild(
                'Stats',
                array('uri' => $admin->generateUrl('stats', array('id' => $id)))
            );
        }
    }

    public function getObjectMetadata($object)
    {
        $url = null;
        if (!is_null($object->getLogo()))
        {
            $media = $object->getLogo();
            $provider = $this->getConfigurationPool()->getContainer()->get($media->getProviderName());

            $url = $provider->generatePublicUrl($media, 'club_big');
        }
        return new Metadata($this->toString($object), null, $url);
    }
}

<?php

namespace Application\BDEBundle\Admin;

use Sonata\NewsBundle\Admin\PostAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\AdminInterface;

class PostAdmin extends BaseAdmin
{
    public $supportsPreviewMode = true;
    protected $baseRouteName = 'admin_application_sonata_news_post';
    protected $baseRoutePattern = 'application/sonata/news/post';
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC', 
        '_sort_by' => 'id'
    );
    protected $listModes = array();

    public function getTemplate($name)
    {
        switch ($name) {
            case 'preview':
                return 'ApplicationSonataNewsBundle:Post:preview.html.twig';
                break;
            case 'stats':
                return 'ApplicationSonataAdminBundle:Stats:show.html.twig';
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
        $formMapper->remove('commentsCloseAt');
        $formMapper->remove('commentsDefaultStatus');
        $formMapper->remove('image');

        if (!$this->isGranted('OPERATOR'))
        {
            $formMapper->remove('author');
            $formMapper->remove('enabled');
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
                    'btn_delete' => true,
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
                    'label'         => 'Photo au format rectangle',
                ))
                ->add('thumbnail', 'sonata_media_type', array(
                    'required'      => false,
                    'provider'      => 'sonata.media.provider.image',
                    'context'       => 'news',
                    'new_on_update' => false,
                    'label'         => 'Photo au format carré',
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

        if (!$this->isGranted('OPERATOR'))
        {
            $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
            $object->setAuthor($user);
            $object->setEnabled(true);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $listMapper
            ->remove('custom')
            ->remove('publicationDateStart')
            ->remove('commentsEnabled')
            ->add('custom', 'string', array('template' => 'ApplicationSonataNewsBundle:Admin:list_post_custom.html.twig', 'label' => 'Post'))
            ->add('publicationDateStart')
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

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setCommentsDefaultStatus(1);

        return $instance;
    }

    // protected function configureRoutes(RouteCollection $collection)
    // {
    //     parent::configureRoutes($collection);
    //     $collection->add('stats', $this->getRouterIdParameter().'/stats');
    // }

    // protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    // {
    //     parent::configureSideMenu($menu, $action, $childAdmin);
    //     if (!$childAdmin && !in_array($action, array('edit', 'show', 'history'))) {
    //         return;
    //     }

    //     $admin = $this->isChild() ? $this->getParent() : $this;

    //     $id = $admin->getRequest()->get('id');

    //     $menu->addChild(
    //         'Stats',
    //         array('uri' => $admin->generateUrl('stats', array('id' => $id)))
    //     );
    // }
}

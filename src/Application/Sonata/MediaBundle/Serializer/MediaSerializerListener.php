<?php

namespace Application\Sonata\MediaBundle\Serializer;

use Sonata\CoreBundle\Model\ManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class MediaSerializerListener implements EventSubscriberInterface
{
    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager, ContainerInterface $container)
    {
        $this->manager = $manager;
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    static public function getSubscribedEvents()
    {
        return array(
            array(
				'event'  => 'serializer.post_serialize', 
				'class'  => 'Application\Sonata\MediaBundle\Entity\Media', 
				'method' => 'onPostSerialize'
        	),
        );
    }

    public function onPostSerialize(ObjectEvent $event)
    {
    	$media = $event->getObject();
        $provider = $this->container->get($media->getProviderName());
        $url_thumbnail = $provider->generatePublicUrl($media, $media->getContext().'_big');
        $url = $provider->generatePublicUrl($media, 'reference');

        $event->getVisitor()->addData('url_thumbnail', $url_thumbnail);
        $event->getVisitor()->addData('url', $url);
    }
}

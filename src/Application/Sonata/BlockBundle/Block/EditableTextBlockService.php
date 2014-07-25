<?php

namespace Application\Sonata\BlockBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Sonata\BlockBundle\Exception\BlockNotFoundException;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class EditableTextBlockService extends BaseBlockService
{
	protected $em;
	protected $logger;
	
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Editable TextBlock';
    }
    
    public function __construct($name, EngineInterface $templating, EntityManager $entityManager, LoggerInterface $logger)
    {
        $this->name       = $name;
        $this->templating = $templating;
        $this->em = $entityManager;
        $this->logger = $logger;
    }
	
	function setDefaultSettings(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'template' => 'ApplicationSonataBlockBundle:Block:block_editable_text.html.twig',
			'title'    => 'empty'
		));
	}
	
	public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
	{
		$formMapper->add('settings', 'sonata_type_immutable_array', array(
			'keys' => array(
				array('title', 'text', array('required' => true))
			)
		));
	}
	
	function validateBlock(ErrorElement $errorElement, BlockInterface $block)
	{
		$errorElement
			->with('settings.title')
				->assertNotNull(array())
				->assertNotBlank()
				->assertMaxLength(array('limit' => 50))
				->assertRegex("/[a-zA-Z_]+/")
			->end()
		;
	}
	
	public function execute(BlockContextInterface $blockContext, Response $response = null)
	{
		// merge settings
		$settings = $blockContext->getSettings();
		$editableTextBlock = $this->em->getRepository('ApplicationSonataBlockBundle:EditableTextBlock')->findOneByTitle($settings['title']);

		$this->logger->info(print_r($editableTextBlock, true));

		if (null === $editableTextBlock) 
			$editableTextBlock['content'] = 'Le block '.$settings['title'].' n\'existe pas';

		return $this->renderResponse($blockContext->getTemplate(), array(
			'editableTextBlock' => $editableTextBlock,
			'block'             => $blockContext->getBlock(),
			'settings'          => $settings
		), $response);
	}
}
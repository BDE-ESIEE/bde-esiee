<?php

/**
 * This file is part of the FOSCommentBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Application\Sonata\CommentBundle\Form;

use Sonata\CommentBundle\Note\NoteProvider;
use Sonata\CommentBundle\Form\CommentType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * This is a FOSCommentBundle overridden form type
 */
class CommentType extends BaseType
{
    /**
     * @var NoteProvider
     */
    protected $noteProvider;
    protected $sc;

    /**
     * Constructor
     *
     * @param NoteProvider $noteProvider
     */
    public function __construct(NoteProvider $noteProvider, SecurityContext $securityContext)
    {
        $this->noteProvider = $noteProvider;
        $this->sc = $securityContext;
    }

    /**
     * Is comment model implementing signed interface?
     *
     * @var boolean
     */
    protected $isSignedInterface = false;

    /**
     * Configures a Comment form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (is_string($this->sc->getToken()->getUser())) {
            $builder->add('authorName', 'text', array(
                'required' => true,
                'data'     => ''
            ));

            $this->vars['add_author'] = $options['add_author'];
        }

        $builder
            ->add('website', 'url', array('required' => false))
            ->add('email', 'email', array('required' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'add_author' => !$this->isSignedInterface,
            'show_note'  => false
        ));
    }

    /**
     * Sets if comment model is implementing signed interface
     *
     * @param boolean $isSignedInterface
     */
    public function setIsSignedInterface($isSignedInterface)
    {
        $this->isSignedInterface = $isSignedInterface;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "application_sonata_comment_comment";
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return "sonata_comment_comment";
    }
}

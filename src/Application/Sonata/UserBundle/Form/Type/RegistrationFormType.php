<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'label'                          => 'form.username', 
                'translation_domain'             => 'FOSUserBundle',
                'horizontal_label_class'         => 'col-lg-3 col-sm-3 control-label',
                'horizontal_input_wrapper_class' => 'col-lg-9 col-sm-9',
            ))
            ->add('email', 'email', array(
                'label'                          => 'form.email', 
                'translation_domain'             => 'FOSUserBundle',
                'horizontal_label_class'         => 'col-lg-3 col-sm-3 control-label',
                'horizontal_input_wrapper_class' => 'col-lg-9 col-sm-9',
            ))
            ->add('resource', 'entity', array(
                'class'                          => 'Application\BDEBundle\Entity\Resource',
                'label'                          => 'Promo :',
                'horizontal_label_class'         => 'col-lg-3 col-sm-3 control-label',
                'horizontal_input_wrapper_class' => 'col-lg-9 col-sm-9',
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array(
                    'label'                          => 'form.password',
                    'horizontal_label_class'         => 'col-lg-3 col-sm-3 control-label',
                    'horizontal_input_wrapper_class' => 'col-lg-9 col-sm-9',
                ),
                'second_options' => array(
                    'label'                          => 'form.password_confirmation',
                    'horizontal_label_class'         => 'col-lg-3 col-sm-3 control-label',
                    'horizontal_input_wrapper_class' => 'col-lg-9 col-sm-9',
                ),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    public function getName()
    {
        return 'sonata_user_registration';
    }
}

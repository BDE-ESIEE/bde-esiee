<?php

namespace Application\BDEBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\BDEBundle\Entity\Product;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id',   'hidden')
            ->add('email', 'email', array(
                'mapped' => false, 
                'label' => false,
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array(
                        'pattern' => '/^[a-z0-9]+@[edu\.]*esiee\.fr$/',
                        'match'   => 'true',
                        'message' => 'Vous devez entrer votre mail ESIEE',
                    )),
                ),
            ))
            ->add('Confirmer', 'submit')
        ;

        // $myExtraFieldValidator = function(FormEvent $event){
        //     $form = $event->getForm();
        //     $myExtraField = $form->get('email')->getData();
        //         var_dump($myExtraField);
        //     if (empty($myExtraField)) {
        //         $form['email']->addError(new FormError("email must not be empty"));
        //     } elseif (!preg_match("#^[a-z]+\.[a-z0-9]+@[edu\.]*esiee\.fr$#", $myExtraField)) {
        //         $form['email']->addError(new FormError("email must be valide"));
        //     }
        // };

        // $builder->addEventListener(FormEvents::POST_SUBMIT, $myExtraFieldValidator);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\BDEBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'application_bdebundle_producttype';
    }
}
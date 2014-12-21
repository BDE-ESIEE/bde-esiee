<?php

namespace Application\StudentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\FormType;

/**
 * @FormType
 */
class StudentArrayType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'student_array';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);


        $resolver->setDefaults(array(
            'class'    => 'ApplicationStudentBundle:Student',
            'multiple' => true,
            'expanded' => true,
        ));
    }
}
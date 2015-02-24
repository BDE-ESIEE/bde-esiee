<?php

namespace Application\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LostPropertyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Titre'
            ))
            ->add('date', 'sonata_type_datetime_picker', array(
                'dp_language'    => 'fr',
                'date_format'    => "d.m.Y, H:i",
                'dp_use_seconds' => false,
                'dp_min_date'    => '1/1/'.(new \DateTime())->format("Y"),
                'label_attr'     => array('class' => 'fix-date-align')
            ))
            ->add('found', 'choice', array(
                'label' => 'Objet ...',
                'choices' => array('1' => 'Trouvé', '0' => 'Perdu'),
                'expanded' => true,
                'empty_value' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\ServiceBundle\Entity\LostProperty'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'application_servicebundle_lostproperty';
    }
}

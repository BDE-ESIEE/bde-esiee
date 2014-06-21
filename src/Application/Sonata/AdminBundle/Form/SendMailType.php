<?php

namespace Application\Sonata\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SendMailType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('news', 'entity', array(
				'class'    => 'ApplicationSonataNewsBundle:Post',
				//'property' => 'title',
				'multiple' => true,
				'expanded' => true,
				'query_builder' => function(EntityRepository $er) {
			        return $er->createQueryBuilder('p')
			        	->where('p.publicationDateStart >= :date_from')
			        	->setParameter('date_from', (new \DateTime())->modify('-1 month'))
			            ->orderBy('p.publicationDateStart', 'ASC');
			    },
			))
			->add('intro', 'textarea', array('required' => false))
			->add('email', 'email')
			->add('aperçu', 'submit')
			->add('envoyer', 'submit')
		;
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'horizontal' => false,
        ));
    }

	public function getName()
	{
		return 'application_sonata_adminbundle_sendmail';
	}
}
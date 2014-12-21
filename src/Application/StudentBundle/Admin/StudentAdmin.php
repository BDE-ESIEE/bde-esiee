<?php

namespace Application\StudentBundle\Admin;

use Application\Sonata\AdminBundle\Admin\AdminMerge as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Ferus\FairPayApi\Exception\ApiErrorException;
use Ferus\FairPayApi\FairPay;

class StudentAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('clubs')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
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
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id', 'student')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', 'text')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('clubs', 'member')
        ;
    }

    public function prePersist($student)
    {
        try{
            $fairpay = new FairPay();
            if ((boolean) $this->configurationPool->getContainer()->getParameter('use_proxy')) {
                $fairpay->setCurlParam(CURLOPT_HTTPPROXYTUNNEL, true);
                $fairpay->setCurlParam(CURLOPT_PROXY, "proxy.esiee.fr:3128");
            }
            $student_infos = $fairpay->getStudent($student->getId());
            $student->setFirstName($student_infos->first_name);
            $student->setLastName($student_infos->last_name);
            $student->setEmail($student_infos->email);
        }
        catch(ApiErrorException $e){
        }
    }
}

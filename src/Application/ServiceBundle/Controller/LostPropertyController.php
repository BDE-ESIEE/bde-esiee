<?php

namespace Application\ServiceBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\RestBundle\Controller\Annotations as Rest;
use Application\ServiceBundle\Entity\LostProperty;
use Application\ServiceBundle\Form\LostPropertyType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LostPropertyController extends FOSRestController
{
    protected $request;
    protected $em;
    protected $security;

    /**
     * @ApiDoc(
     *  description="Retrieves the list of lost properties",
     *  resource=true,
     *  output={"class"="Application\ServiceBundle\Entity\LostProperty"},
     *  statusCodes={
     *      200="Returned when successful"
     *  }
     * )
     * @Rest\View(statusCode=200)
     */
    public function indexAction()
    {
        $lost_property_list = $this->getDoctrine()->getManager()->getRepository('ApplicationServiceBundle:LostProperty')->findBy(array(), array('found' => 'ASC', 'date' => 'ASC'));

        $view = $this->view($lost_property_list, 200)
            ->setTemplate("ApplicationServiceBundle:LostProperty:index.html.twig")
            ->setTemplateVar('lost_property_list')
        ;

        return $this->handleView($view);
    }


    public function addAction()
    {
        if (!$this->security->isGranted('ROLE_APPLICATION_SERVICE_ADMIN_LOST_PROPERTY_STAFF'))
        {
            throw new AccessDeniedException();
        }

        $lostProperty = new LostProperty;
        $form = $this->createForm(new LostPropertyType, $lostProperty);

        if ($this->request->getMethod() == 'POST') {
            $form->handleRequest($this->request);

            if ($form->isValid()) {
                $this->em->persist($lostProperty);
                $this->em->flush();

                // création de l'ACL
                $aclProvider = $this->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($lostProperty);
                $acl = $aclProvider->createAcl($objectIdentity);

                // retrouve l'identifiant de sécurité de l'utilisateur actuellement connecté
                $user = $this->security->getToken()->getUser();
                $securityIdentity = UserSecurityIdentity::fromAccount($user);

                // donne accès au propriétaire
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Cet objet a bien été ajouté.'
                );

                return $this->redirect($this->generateUrl('application_service_lost_property'));
            }
        }

        return $this->render('ApplicationServiceBundle:LostProperty:add.html.twig', array(
            'lostProperty' => $lostProperty,
            'form'         => $form->createView(),
        ));
    }
}

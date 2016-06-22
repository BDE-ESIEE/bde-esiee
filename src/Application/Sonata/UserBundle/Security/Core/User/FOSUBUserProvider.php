<?php

namespace Application\Sonata\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException as AuthenticationException;

class FOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param array                $properties  Property mapping.
     */
    public function __construct(UserManagerInterface $userManager, EntityManager $em, ValidatorInterface $validator, array $properties)
    {
        parent::__construct($userManager, $properties);
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        $serviceName       = $response->getResourceOwner()->getName();
        $setterAccessToken = 'set' . ucfirst($serviceName) . 'AccessToken';
        $setterId          = 'set' . ucfirst($serviceName) . 'Id';

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            $this->disconnect($existingUser, $response);

            $this->userManager->updateUser($existingUser);
        }
        //we connect current user, set current user id and token
        $this->accessor->setValue($user, $property, $username);

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        $serviceName = $response->getResourceOwner()->getName();
        $setterAccessToken = 'set' . ucfirst($serviceName) . 'AccessToken';
        $setterId = 'set' . ucfirst($serviceName) . 'Id';

        // if null just create new user and set it properties
        if (null === $user) {
            $resources = $this->em->getRepository('ApplicationBDEBundle:Resource')->findAll();

            $user = $this->userManager->createUser();
            $user
                ->setUsername($response->getRealName())
                ->setEmail($userEmail)
                ->setPlainPassword($response->getUsername())
                ->setResource($resources[0])
                ->setEnabled(true)
            ;

            $user->$setterId($response->getUsername());
            $user->$setterAccessToken($response->getAccessToken());

            $errors = $this->validator->validate($user);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    /* @var $error \Symfony\Component\Validator\ConstraintViolation */
                    throw new AuthenticationException($error->getMessage());
                }
            }

            // ... save user to database
            $this->userManager->updateUser($user);

            return $user;
        }

        // else update access token of existing user
        $user->$setterAccessToken($response->getAccessToken());//update access token

        return $user;
    }
}

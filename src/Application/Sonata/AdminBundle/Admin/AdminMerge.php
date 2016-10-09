<?php

namespace Application\Sonata\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;

use Doctrine\DBAL\DBALException;
use Sonata\AdminBundle\Exception\ModelManagerException;

abstract class AdminMerge extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function create($object)
    {
        $this->prePersist($object);
        foreach ($this->extensions as $extension) {
            $extension->prePersist($this, $object);
        }

        /* ---> Start of modified code <--- */
        try {
            $em = $this->getModelManager()->getEntityManager($object);
            $result = $em->merge($object);
            $em->flush();
        } catch (\PDOException $e) {
            throw new ModelManagerException(sprintf('Failed to create object: %s', ClassUtils::getClass($object)), $e->getCode(), $e);
        } catch (DBALException $e) {
            throw new ModelManagerException(sprintf('Failed to create object: %s', ClassUtils::getClass($object)), $e->getCode(), $e);
        }
        /* ---> End of modified code <--- */

        // BC compatibility
        if (null !== $result) {
            $object = $result;
        }

        $this->postPersist($object);
        foreach ($this->extensions as $extension) {
            $extension->postPersist($this, $object);
        }

        $this->createObjectSecurity($object);

        return $object;
    }
}

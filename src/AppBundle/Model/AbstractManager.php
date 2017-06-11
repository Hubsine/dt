<?php

namespace AppBundle\Model;

use AppBundle\Doctrine\EntityInterface;
use AppBundle\Model\ManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of AbstractManager
 *
 * @author Hubsine
 */
abstract class AbstractManager implements ManagerInterface{

    /**
     * @var ObjectManager
     */
    protected $objectManager;
    
    /**
     *
     * @var string
     */
    protected $class;
    
    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->objectManager->getRepository($this->class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function createEntity()
    {
        $class = $this->class;
        $object = new $class();

        return $object;
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteEntity(EntityInterface $entity)
    {
        $this->objectManager->remove($entity);
        $this->objectManager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function reloadEntity(EntityInterface $entity)
    {
        $this->objectManager->refresh($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function updateEntity(EntityInterface $entity, $andFlush = true)
    {
        $this->objectManager->persist($entity);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
}

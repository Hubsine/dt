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
     * @return objectManager
     */
    public function getEntityManager()
    {
        return $this->objectManager;
    }
    
    /**
     * @return ObjectRepository
     */
    public function getRepository($className = null)
    {
        if( !empty($className) )
        {
            return $this->objectManager->getRepository($className);
        }
        
        return $this->objectManager->getRepository($this->class);
    }
    
    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
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
    
    /**
     * {@inheritdoc}
     */
    public function mergeEntity(EntityInterface $entity)
    {
        $this->objectManager->merge($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->objectManager->flush();
    }
}

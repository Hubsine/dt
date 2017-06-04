<?php

namespace AppBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Doctrine\EntityInterface;

/**
 * Description of ManagerInterface
 *
 * @author Hubsine
 */
interface ManagerInterface {

    public function __construct(ObjectManager $om, $class);

    public function getRepository();
    
    public function createEntity();
    
    public function deleteEntity(EntityInterface $entity);
    
    public function reloadEntity(EntityInterface $entity);
    
    public function updateEntity(EntityInterface $entity);
}

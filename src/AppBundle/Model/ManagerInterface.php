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
    
    public function create();
    
    public function delete(EntityInterface $entity);
    
    public function reload(EntityInterface $entity);
    
    public function update(EntityInterface $entity);
}

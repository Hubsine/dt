<?php

namespace AppBundle\Doctrine;

use AppBundle\Model\AbstractManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of BaseManager
 *
 * @author Hubsine
 */
class BaseManager extends AbstractManager{
    
    public function __construct(ObjectManager $om, $className = null) 
    {
        $this->objectManager = $om;
    }
    
}

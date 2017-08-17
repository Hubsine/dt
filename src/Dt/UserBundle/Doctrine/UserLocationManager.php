<?php

namespace Dt\UserBundle\Doctrine;

use AppBundle\Model\AbstractManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of UserLocationManager
 *
 * @author Hubsine
 */
class UserLocationManager extends AbstractManager{
    
    public function __construct(ObjectManager $om, $class) 
    {
        $this->objectManager = $om;
        $this->class = $class;
    }
    
}

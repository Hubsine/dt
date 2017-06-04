<?php

namespace Dt\AdminBundle\Doctrine;

use AppBundle\Model\AbstractManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of AboutUserInterface
 *
 * @author Hubsine
 */
class AboutUsersManager extends AbstractManager{
    
    public function __construct(ObjectManager $om, $class) {
        
        $this->objectManager = $om;
        $this->class = $class;
        
    }
    
    
}

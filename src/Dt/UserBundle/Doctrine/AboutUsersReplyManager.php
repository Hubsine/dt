<?php

namespace Dt\UserBundle\Doctrine;

use AppBundle\Model\AbstractManager;
use Doctrine\Common\Persistence\ObjectManager;
use Dt\UserBundle\Entity\User;

/**
 * Description of AboutUserReplyManager
 *
 * @author Hubsine
 */
class AboutUserReplyManager extends AbstractManager{
    
    public function __construct(ObjectManager $om, $class) {
        
        $this->objectManager = $om;
        $this->class = $class;
        
    }
    
    public function getUserReply(User $user){
        
        return $this->getRepository()->findBy(array('user' => $user));
    }
}

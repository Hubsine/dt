<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\EventListener\AppClientEventListener;

/**
 * Description of UserExtension
 *
 * @author Hubsine
 */
class UserExtension extends \Twig_Extension 
{
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getUserOnlineOrOfflineClass', array($this, 'getUserOnlineOrOfflineClassFunction')),
        );
    }

    public function getUserOnlineOrOfflineClassFunction(UserInterface $user) 
    {
        echo count($this->connections);
        return ($this->userIsOnline($user)) ? "online" : "offline";
    }
    
    public function addConnections($user, $connection)
    {
        if( $user instanceof UserInterface )
        {
            $this->connections[$user->getId()] = $connection;
        }
    }
    
    /**
     * Check if user is online or not
     * 
     * @param UserInterface $user
     * @return boolean
     */
    public function userIsOnline(UserInterface $user)
    {
        
        $userId = $user->getId();
        $connection = ( isset($this->connections[$userId]) ) ? $this->connections[$userId] : null;
        
        if( $connection instanceof ConnectionInterface )
        {
            return true;
        }
        
        return false;
        
    }
}

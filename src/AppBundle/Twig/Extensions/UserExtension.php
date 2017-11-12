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
    private $gosAppClient;

    public function __construct(AppClientEventListener $gosAppClient) 
    {
        $this->gosAppClient = $gosAppClient;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getUserOnlineOrOfflineClass', array($this, 'getUserOnlineOrOfflineClassFunction')),
        );
    }

    public function getUserOnlineOrOfflineClassFunction(UserInterface $user) 
    {
        return ($this->gosAppClient->userIsOnline($user)) ? "online " . $this->gosAppClient->getNumberConnections() : "offline " . $this->gosAppClient->getNumberConnections();
    }
}

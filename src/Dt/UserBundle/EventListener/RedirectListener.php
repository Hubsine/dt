<?php

namespace Dt\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Dt\UserBundle\Event\OAuthUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use FOS\UserBundle\FOSUserEvents;
use Dt\UserBundle\DtUserEvents;

/**
 * Description of LoadUserByOAuthUserListener
 *
 * @author Hubsine
 */
class RedirectListener implements EventSubscriberInterface{

    public $checker;
    
    public $router;


    public function __construct(AuthorizationChecker $checker, Router $router) {
      
        $this->checker = $checker;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'redirectTo',
            DtUserEvents::USER_LOGIN_INITIALIZE => 'redirectTo'
        );
    }
    
    /**
     * Il s'agit de rediriger vers la page d'accueil toute si la personne est connecté
     * 
     * @param GetResponseUserEvent $event
     */
    public function redirectTo(GetResponseUserEvent $event){
        
        if($this->checker->isGranted('IS_AUTHENTICATED_FULLY')){
            
            $url = $this->router->generate('homepage');
            $response = new RedirectResponse($url);
            
            $event->setResponse($response);
        }
    }
          
}

<?php

namespace Dt\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Dt\UserBundle\Event\OAuthUserEvent;
use Dt\UserBundle\DtUserEvents;
use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Entity\ProfilePicture;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use AppBundle\FileInfo;

/**
 * Description of LoadUserByOAuthUserListener
 *
 * @author Hubsine
 */
class LoadUserByOAuthUserListener implements EventSubscriberInterface{

    public $uploadableManager; 
    
    public function __construct(UploadableManager $uploadableManager) {
        
        $this->uploadableManager = $uploadableManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            DtUserEvents::HYDRATE_USER_FROM => 'hydrateByResourceOwners',
        );
    }
    
    public function hydrateByResourceOwners(OAuthUserEvent $event)
    {
        $resourceOwnerName = $event->getUserResponse()->getResourceOwner()->getName();
        
        switch ($resourceOwnerName) 
        {
            case 'facebook':
                $this->hydrateByFacebook($event);
            break;

            case 'google':
                
            break;
        
            default:
            break;
        }
        
    }
    
    public function hydrateByFacebook(OAuthUserEvent $event)
    {
        $user = $event->getUser();
        $profilePicture = $event->getProfilePicture();
        $ownerResponse = $event->getUserResponse();
        $fbDatas = $event->getUserResponse()->getResponse();

        // Set User
        $user->setFirstName($ownerResponse->getFirstName());
        $user->setLastName($ownerResponse->getLastName());
        $user->setEmail($ownerResponse->getEmail());
        $user->setUsername($ownerResponse->getFirstName());
        $user->setFacebookId($fbDatas['id']);
        $user->setGender($fbDatas['gender']);
        $user->setAgeRange($fbDatas['age_range']['min']);
        
        
    }   
          
}

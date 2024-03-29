<?php

namespace Dt\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Dt\UserBundle\Event\OAuthUserEvent;
use Dt\UserBundle\DtUserEvents;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Oneup\AclBundle\Security\Acl\Manager\AclManager;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;

/**
 * Description of LoadUserByOAuthUserListener
 *
 * @author Hubsine
 */
class LoadUserByOAuthUserListener implements EventSubscriberInterface{

    public $uploadableManager; 
    public $aclManager;

    public function __construct(UploadableManager $uploadableManager, AclManager $aclManager) {
        
        $this->uploadableManager = $uploadableManager;
        $this->aclManager = $aclManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            DtUserEvents::HYDRATE_USER_FROM => 'hydrateByResourceOwners',
            DtUserEvents::OAUTH_REGISTRATION_SUCCESS => 'oauthUserRegistrationSuccess'
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
                $this->hydrateByGoogle($event);
            break;
        
            default:
            break;
        }
        
    }
    
    public function hydrateByFacebook(OAuthUserEvent $event)
    {
        $user = $event->getUser();
        $ownerResponse = $event->getUserResponse();
        $fbDatas = $ownerResponse->getResponse();

        // Set User
        $user->setFirstName($ownerResponse->getFirstName());
        $user->setLastName($ownerResponse->getLastName());
        $user->setEmail($ownerResponse->getEmail());
        $user->setUsername($ownerResponse->getFirstName());
        $user->setFacebookId($fbDatas['id']);
        $user->setGender($fbDatas['gender']);
        $user->setAgeRange($fbDatas['age_range']['min']);
        
    }   
    
    public function hydrateByGoogle(OAuthUserEvent $event){
        
        $user = $event->getUser();
        $ownerResponse = $event->getUserResponse();
        $googleData = $event->getUserResponse()->getResponse();
        
        // Set User
        $user->setFirstName($ownerResponse->getFirstName());
        $user->setLastName($ownerResponse->getLastName());
        $user->setEmail($ownerResponse->getEmail());
        $user->setUsername($ownerResponse->getFirstName());
        $user->setGoogleId((isset($googleData['id']) ? $googleData['id'] : $user->getGoogleId() ));
        $user->setGender((isset($googleData['gender']) ? $googleData['gender'] : $user->getGender() ));
        $user->setVerifiedEmail((isset($googleData['verified_email']) ? $googleData['verified_email'] : $user->getVerifiedEmail() ));
        
    }
        
    public function oauthUserRegistrationSuccess(OAuthUserEvent $event){
        
        $user = $event->getUser();
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
            
        $this->aclManager->addObjectPermission($user, MaskBuilder::MASK_OWNER, $securityIdentity);
        
    }
}

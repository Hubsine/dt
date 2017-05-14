<?php 

namespace Dt\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Entity\ProfilePicture;
use Dt\UserBundle\Event\OAuthUserEvent;
use Dt\UserBundle\DtUserEvents;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use FOS\UserBundle\Util\TokenGenerator;

class DtFOSUBUserProvider extends BaseFOSUBProvider
{
    
    /**
     * @var TraceableEventDisptacher
     */
    public $eventDispatcher;
    
    /**
     * @var  ValidatorInterface
     */
    public $validator;
    
    /**
     * @var Session
     */
    public $session;

    /**
     * 
     * @param UserManagerInterface $userManager
     * @param array $properties
     * @param TraceableEventDispatcher $eventDispatcher
     */
    public function __construct(UserManagerInterface $userManager, array $properties, 
            TraceableEventDispatcher $eventDispatcher, ValidatorInterface $validator, Session $session) {
        
        parent::__construct($userManager, $properties);
        
        $this->eventDispatcher = $eventDispatcher;
        $this->validator = $validator;
        $this->session = $session;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        // if null just create new user and set it properties
        if (null === $user) {

            $user = new User();
            $profilePicture = new ProfilePicture();
            $tokenGenerator = new TokenGenerator();
            $userPlainPassword = $tokenGenerator->generateToken();
        
            $user->setPlainPassword(substr($userPlainPassword,0, 15));
            
            $hydrateUserEvent = new OAuthUserEvent($user, $profilePicture, $response);
            $this->eventDispatcher->dispatch(DtUserEvents::HYDRATE_USER_FROM, $hydrateUserEvent);

            // Validation of User
            $errors = $this->validator->validate($user, null, array('FbRegistration'));
            
            if($errors->count() > 0){
                foreach ($errors as $key => $violation) {
                    $this->session->getFlashBag()->add('danger', $violation->getMessage());
                }
            }else{
                $user->setEnabled(true);
            }
            
            $this->userManager->updateUser($user);
            
            return $user;
        }
        
        // else update access token of existing user
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token

        return $user;
    }
}
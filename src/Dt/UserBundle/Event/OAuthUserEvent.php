<?php

namespace Dt\UserBundle\Event;

use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Entity\UserPicture;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Description of HydrateUserEvent
 *
 * @author Hubsine
 */
class OAuthUserEvent extends Event{
    
    /**
     * @var User
     */
    protected $user;
    
    /**
     * @var UserPicture
     */
    protected $profilePicture;
    
    /**
     * @var UserResponseInterface
     */
    private $userResponse;
    
    /**
     * 
     * @param User $user
     * @param UserPicture $profilePicture
     * @param UserResponseInterface $userResponse
     * 
     */
    public function __construct(User $user, UserPicture $profilePicture, UserResponseInterface $userResponse) {
        
        $this->user = $user;
        $this->profilePicture = $profilePicture;
        $this->userResponse = $userResponse;
        
    }
    
    /**
     * @return User
     */
    public  function getUser(): User {
        return $this->user;
    }

    /**
     * @return UserPicture
     */
    public function getProfilePicture(): UserPicture {
        return $this->profilePicture;
    }

    /**
     * @return UserResponseInterface
     */
    public function getUserResponse(): UserResponseInterface {
        return $this->userResponse;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user) {
        $this->user = $user;
    }

    /**
     * @param UserPicture $profilePicture
     */
    public function setProfilePicture(UserPicture $profilePicture) {
        $this->profilePicture = $profilePicture;
    }
    
}

<?php

namespace Dt\UserBundle\Event;

use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Entity\ProfilePicture;
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
     * @var ProfilePicture
     */
    protected $profilePicture;
    
    /**
     * @var UserResponseInterface
     */
    private $userResponse;
    
    /**
     * 
     * @param User $user
     * @param ProfilePicture $profilePicture
     * @param UserResponseInterface $userResponse
     * 
     */
    public function __construct(User $user, ProfilePicture $profilePicture, UserResponseInterface $userResponse) {
        
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
     * @return ProfilePicture
     */
    public function getProfilePicture(): ProfilePicture {
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
     * @param ProfilePicture $profilePicture
     */
    public function setProfilePicture(ProfilePicture $profilePicture) {
        $this->profilePicture = $profilePicture;
    }
    
}

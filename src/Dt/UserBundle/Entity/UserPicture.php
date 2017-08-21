<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Picture;

/**
 * UserPicture
 *
 * @ORM\Table(name="dt_user_picture")
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\UserPictureRepository")
 */
class UserPicture extends Picture
{

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userPictures")
     */
    private $user;


    /**
     * Set user
     *
     * @param \Dt\UserBundle\Entity\User $user
     * @return UserPicture
     */
    public function setUser(\Dt\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Dt\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}

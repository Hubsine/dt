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
     * @ORM\ManyToOne(targetEntity="User", mappedBy="id")
     */
    private $user;

    /**
     * Set user
     *
     * @param \stdClass $user
     * @return UserPicture
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass 
     */
    public function getUser()
    {
        return $this->user;
    }
}

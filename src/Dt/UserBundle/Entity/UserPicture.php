<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Picture;

/**
 * UserPicture
 *
 * @ORM\Table(name="dt_user_picture")
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\UserPictureRepository")
 * 
 * @Gedmo\Uploadable(
 *  pathMethod="getUploadPathFolder", 
 *  allowedTypes="image/jpeg, image/png", 
 *  maxSize="16777216", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class UserPicture extends Picture
{
    
    /** Dossier d'upload des fichiers de 'lutilisateur. %d is user id. */
    const USER_UPLODED_FOLDER = 'uploads/users/%d';

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userPictures")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $user;

    /**
     * @var mixed
     * 
     * @Assert\Image(
     *      maxSize="2M",
     *      mimeTypes={"image/jpeg", "image/jpg","image/png"})
     */
    protected $file;
    
    public function getUploadPathFolder($defaultPath)
    {
        $userId             = $this->getUser()->getId();
        $userUploadFolder   = sprintf( self::USER_UPLODED_FOLDER, $userId );
        
        return parent::getAbsolutetUploadRootDir() . '/' . $userUploadFolder;
    }

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

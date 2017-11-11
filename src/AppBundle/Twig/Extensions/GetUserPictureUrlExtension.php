<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Filesystem\Filesystem;
use Dt\UserBundle\Entity\UserPicture;

/**
 * Description of FileExists
 *
 * @author Hubsine
 */
class GetUserPictureUrlExtension extends \Twig_Extension 
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('getUserPictureUrl', array($this, 'userPictureUrlFilter')),
        );
    }

    public function userPictureUrlFilter(UserPicture $userPicture = null)
    {
        if( $userPicture === null )
        {
            return null;
        }
        
        $userId = $userPicture->getUser()->getId();
        $pictureName = $userPicture->getName();
        $userUploadedFolder = UserPicture::USER_UPLOADED_FOLDER;
        
        return sprintf($userUploadedFolder, $userId) . '/' . $pictureName;
    }
}

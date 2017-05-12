<?php

namespace Dt\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(name="profile_picture")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Uploadable(pathMethod="getPath", allowedTypes="jpg,jpeg,png", maxSize="16777216", path="/my/path", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class ProfilePicture
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    use TimestampableEntity;

    /**
     * @ORM\Column
     * @Gedmo\UploadableFilePath
     */
    protected $path;

    /**
     * @ORM\Column
     * @Gedmo\UploadableFileName
     */
    protected $name;

    /**
     * @ORM\Column(name="mime_type")
     * @Gedmo\UploadableFileMimeType
     */
    protected $mimeType;

    /**
     * @ORM\Column(type="decimal")
     * @Gedmo\UploadableFileSize
     */
    protected $size;


    public function myCallbackMethod(array $info)
    {
        // Do some stuff with the file..
    }
    
    public function getPath($defaultPath){
        
    }

}
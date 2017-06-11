<?php

namespace Dt\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="dt_profile_picture")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Uploadable(pathMethod="getPathFolder", allowedTypes="jpg,jpeg,png", maxSize="16777216", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class ProfilePicture
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    use SoftDeleteableEntity;
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

    /**
     * 
     * @param string $defaultPath
     * @return string
     */
    public function getPathFolder($defaultPath){
        return '/uploads';
    }
    
    /**
     * 
     * @param string $defaultPath
     * @return string
     */
    public function getPath(){
        return $this->path;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getMimeType() {
        return $this->mimeType;
    }

    public function getSize() {
        return $this->size;
    }
    
    public function setPath($path){
        $this->path = $path;
        
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        
        return $this;
    }

    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
        
        return $this;
    }

    public function setSize($size) {
        $this->size = $size;
        
        return $this;
    }


}
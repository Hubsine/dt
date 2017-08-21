<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * 
 * @MappedSuperclass
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @Gedmo\Uploadable(
 *  pathMethod="getPathFolder", 
 *  allowedTypes="jpg,jpeg,png", 
 *  maxSize="16777216", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 * 
 * @author Hubsine
 */
class Picture {
    
    use SoftDeleteableEntity;
    use TimestampableEntity;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
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

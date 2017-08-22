<?php

namespace AppBundle\Model;

use AppBundle\Doctrine\EntityInterface;

/**
 * Description of PictureEntityInterface
 *
 * @author Hubsine
 */
interface PictureEntityInterface {
    
    /**
     * Get path of folder where file are uploaded
     * 
     * @return string
     */
    public function getUploadPathFolder();
}

<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Description of LookingFor
 *
 * @author Hubsine
 * 
 * @ORM\Entity
 * @ORM\Table(name="dt_looking_for")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * 
 */
class LookingFor {
    
    use SoftDeleteableEntity;
    use TimestampableEntity;
    
    /**
     * @var array
     * 
     * @ORM\Column(type="array", length=10, name="gender", nullable=true)
     */
    private $gender;
    
    private $ageRange = array('min', 'max');
    
    private $relationships;
    
    private $localisation;
}

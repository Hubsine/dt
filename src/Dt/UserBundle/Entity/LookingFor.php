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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var Dt\UserBundle\Entity\User
     * 
     * @ORM\OneToOne(targetEntity="Dt\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @var array
     * 
     * @ORM\OneToMany(targetEntity="Dt\AdminBundle\Entity\LookingForMeta")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Expression(
     *      "value.getOnProperty() == 'genders'",
     *      message="dt_looking_for.genders.expression"
     * )
     */
    private $genders;
    
    /**
     * @var type 
     * 
     * @ORM\OneToMany(targetEntity="Dt\AdminBundle\Entity\LookingForMeta")
     * 
     * @Assert\Expression(
     *      "value.getOnProperty() == 'relationships'",
     *      message="dt_looking_for.relationships.expression"
     * )
     */
    private $relationships;
    
    /**
     * @var array
     * 
     * @ORM\Column(name="age_range", type="array")
     * 
     * @Assert\Collection(
     *      fields={
     *          "min" = @Assert\Optional(
     *                              @Assert\Type(
     *                                  type="integer", 
     *                                  message="dt_looking_for.age_range.min.type",
     *                              )
     *          ),
     *          "max" = @Assert\Optional(
     *                              @Assert\Type(
     *                                  type="integer", 
     *                                  message="dt_looking_for.age_range.max.type",
     *                              )
     *          )
     *      }
     * )
     * 
     * @Assert\Expression(
     *      "value.min <= value.max",
     *      message="dt_looking_for.age_range.expression"
     * )
     */
    private $ageRange = array('min' => 18, 'max' => 99);
    
    private $localisation;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}

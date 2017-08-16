<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Dt\AdminBundle\Entity\LookingForMeta;
use AppBundle\Doctrine\EntityInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Description of LookingFor
 *
 * @author Hubsine
 * 
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\LookingForRepository")
 * @ORM\Table(name="dt_looking_for")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * 
 * @UniqueEntity(
 *      fields={"user"}, 
 *      message="dt_looking_for.unique_entity"
 * )
 */
class LookingFor implements EntityInterface{
    
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
     * @ORM\ManyToMany(targetEntity="Dt\AdminBundle\Entity\LookingForMeta")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinTable(name="looking_for_meta_genders")
     * 
     * @Assert\Expression(
     *      "value.count() > 0",
     *      message = "dt_looking_for.genders.expression"
     * )
     */
    private $genders;
    
    /**
     * @var type 
     * 
     * @ORM\ManyToMany(targetEntity="Dt\AdminBundle\Entity\LookingForMeta")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinTable(name="looking_for_meta_relationships")
     * 
     * @Assert\Expression(
     *      "value.count() > 0",
     *      message = "dt_looking_for.relationships.expression"
     *  )
     */
    private $relationships;
    
    /**
     * @var array
     * 
     * @ORM\Column(name="age_range_min", type="integer")
     * 
     * @Assert\Type(
     *     type="integer",
     *     message="dt_looking_for.age_range_min.type"
     * )
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 18,
     *     message="dt_looking_for.age_range_min.greater_than_or_equal"
     * )
     * 
     * @Assert\Expression(
     *      "value <= this.getAgeRangeMax()",
     *      message="dt_looking_for.age_range_min.expression"
     * )
     * 
     */
    private $ageRangeMin = 18;
    
    /**
     * @var array
     * 
     * @ORM\Column(name="age_range_max", type="integer")
     * 
     * @Assert\Type(
     *     type="integer",
     *     message="dt_looking_for.age_range_max.type"
     * )
     * 
     * @Assert\GreaterThanOrEqual(
     *     value = 18,
     *     message="dt_looking_for.age_range_max.greater_than_or_equal"
     * )
     * 
     * @Assert\Expression(
     *      "value >= this.getAgeRangeMin()",
     *      message="dt_looking_for.age_range_max.expression"
     * )
     */
    private $ageRangeMax =  99;
    
    /**
     * @var LookingForLocation
     * 
     * @ORM\OneToOne(targetEntity="LookingForLocation", cascade={"persist", "remove"}, inversedBy="lookingFor")
     * 
     * @Assert\Valid()
     */
    private $location;
    
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
     * Set user
     *
     * @param \Dt\UserBundle\Entity\User $user
     * @return LookingFor
     */
    public function setUser(\Dt\UserBundle\Entity\User $user)
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

    /**
     * Set location
     *
     * @param \Dt\UserBundle\Entity\LookingForLocation $location
     * @return LookingFor
     */
    public function setLocation(\Dt\UserBundle\Entity\LookingForLocation $location)
    {
        $location->setLookingFor($this);
        
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Dt\UserBundle\Entity\LookingForLocation 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add genders
     *
     * @param \Dt\AdminBundle\Entity\LookingForMeta $genders
     * @return LookingFor
     */
    public function addGender(LookingForMeta $genders)
    {
        if( $genders->getOnProperty() == LookingForMeta::onPropertyGenders )
        {
            $this->genders[] = $genders;
        }
        
        return $this;
    }

    /**
     * Remove genders
     *
     * @param \Dt\AdminBundle\Entity\LookingForMeta $genders
     */
    public function removeGender(\Dt\AdminBundle\Entity\LookingForMeta $genders)
    {
        $this->genders->removeElement($genders);
    }

    /**
     * Get genders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenders()
    {
        return $this->genders;
    }

    /**
     * Add relationships
     *
     * @param \Dt\AdminBundle\Entity\LookingForMeta $relationships
     * @return LookingFor
     */
    public function addRelationship(\Dt\AdminBundle\Entity\LookingForMeta $relationships)
    {
        if( $relationships->getOnProperty() == LookingForMeta::onPropertyRelationships )
        {
            $this->relationships[] = $relationships;
        }

        return $this;
    }

    /**
     * Remove relationships
     *
     * @param \Dt\AdminBundle\Entity\LookingForMeta $relationships
     */
    public function removeRelationship(\Dt\AdminBundle\Entity\LookingForMeta $relationships)
    {
        $this->relationships->removeElement($relationships);
    }

    /**
     * Get relationships
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * Set ageRangeMin
     *
     * @param integer $ageRangeMin
     * @return LookingFor
     */
    public function setAgeRangeMin($ageRangeMin)
    {
        $this->ageRangeMin = $ageRangeMin;

        return $this;
    }

    /**
     * Get ageRangeMin
     *
     * @return integer 
     */
    public function getAgeRangeMin()
    {
        return $this->ageRangeMin;
    }

    /**
     * Set ageRangeMax
     *
     * @param integer $ageRangeMax
     * @return LookingFor
     */
    public function setAgeRangeMax($ageRangeMax)
    {
        $this->ageRangeMax = $ageRangeMax;

        return $this;
    }

    /**
     * Get ageRangeMax
     *
     * @return integer
     */
    public function getAgeRangeMax()
    {
        return $this->ageRangeMax;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->genders = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relationships = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

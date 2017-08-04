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
     * @var array Dt\AdminBundle\Entity\LookingForMeta
     * 
     * @ORM\ManyToMany(targetEntity="Dt\AdminBundle\Entity\LookingForMeta")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Valid()
     */
    private $lookingForMeta;
    
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
    
    /**
     * @var LookingForLocation
     * 
     * @ORM\OneToOne(targetEntity="LookingForLocation", cascade={"persist", "remove"}, mappedBy="lookingFor")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Valid()
     */
    private $location;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lookingForMeta = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set ageRange
     *
     * @param array $ageRange
     * @return LookingFor
     */
    public function setAgeRange($ageRange)
    {
        $this->ageRange = $ageRange;

        return $this;
    }

    /**
     * Get ageRange
     *
     * @return array 
     */
    public function getAgeRange()
    {
        return $this->ageRange;
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
     * Add lookingForMeta
     *
     * @param \Dt\AdminBundle\Entity\LookingForMeta $lookingForMeta
     * @return LookingFor
     */
    public function addLookingForMetum(\Dt\AdminBundle\Entity\LookingForMeta $lookingForMeta)
    {
        $this->lookingForMeta[] = $lookingForMeta;

        return $this;
    }

    /**
     * Remove lookingForMeta
     *
     * @param \Dt\AdminBundle\Entity\LookingForMeta $lookingForMeta
     */
    public function removeLookingForMetum(\Dt\AdminBundle\Entity\LookingForMeta $lookingForMeta)
    {
        $this->lookingForMeta->removeElement($lookingForMeta);
    }

    /**
     * Get lookingForMeta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLookingForMeta()
    {
        return $this->lookingForMeta;
    }

    /**
     * Set location
     *
     * @param \Dt\UserBundle\Entity\LookingForLocation $location
     * @return LookingFor
     */
    public function setLocation(\Dt\UserBundle\Entity\LookingForLocation $location)
    {
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
}

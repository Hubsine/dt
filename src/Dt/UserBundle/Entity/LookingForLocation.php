<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Dt\UserBundle\Entity\Adress;

/**
 * Localisation
 *
 * @ORM\Table(name="dt_localisation")
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\LookingForLocationRepository")
 * 
 */
class LookingForLocation extends Adress
{
    
    /**
     * @var LookingFor
     * 
     * @ORM\OneToOne(targetEntity="LookingFor", inversedBy="location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lookingFor;
    
    /**
     * Set lookingFor
     *
     * @param \Dt\UserBundle\Entity\LookingFor $lookingFor
     * @return LookingForLocation
     */
    public function setLookingFor(\Dt\UserBundle\Entity\LookingFor $lookingFor)
    {
        $this->lookingFor = $lookingFor;

        return $this;
    }

    /**
     * Get lookingFor
     *
     * @return \Dt\UserBundle\Entity\LookingFor 
     */
    public function getLookingFor()
    {
        return $this->lookingFor;
    }

}

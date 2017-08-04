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
    
    
}

<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dt\UserBundle\Entity\Address;

/**
 * UserLocation
 *
 * @ORM\Table(name="dt_user_location")
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\UserLocationRepository")
 */
class UserLocation extends Address
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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

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
    
}

<?php

namespace Dt\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AboutUsersReply
 *
 * @ORM\Table(name="about_users_reply")
 * @ORM\Entity(repositoryClass="Dt\AdminBundle\Repository\AboutUsersReplyRepository")
 */
class AboutUsersReply
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

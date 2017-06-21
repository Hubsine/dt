<?php

namespace Dt\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * AboutUserMeta
 *
 * @ORM\Table(name="about_user_meta")
 * @ORM\Entity(repositoryClass="Dt\AdminBundle\Repository\AboutUserMetaRepository")
 */
class AboutUserMeta implements Translatable
{
    
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
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     * 
     * @Assert\NotBlank(message="dt_about_user_meta.label.blank", groups={"Profile"})
     * @Assert\Type(type="string", message="dt_about_user_meta.label.type", groups={"Profile"})
     * 
     * @Gedmo\Translatable
     */
    protected $label;


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
     * Set label
     *
     * @param string $label
     * @return AboutUserMeta
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }
}

<?php

namespace Dt\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * LookingForMeta
 *
 * @ORM\Table(name="dt_looking_for_meta")
 * @ORM\Entity(repositoryClass="Dt\AdminBundle\Repository\LookingForMetaRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class LookingForMeta
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
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="on_property", type="string", length=100)
     */
    private $onProperty;


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
     * @return LookingForMeta
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

    /**
     * Set onProperty
     *
     * @param string $onProperty
     * @return LookingForMeta
     */
    public function setOnProperty($onProperty)
    {
        $this->onProperty = $onProperty;

        return $this;
    }

    /**
     * Get onProperty
     *
     * @return string 
     */
    public function getOnProperty()
    {
        return $this->onProperty;
    }
}

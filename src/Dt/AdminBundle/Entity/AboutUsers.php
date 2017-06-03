<?php 

namespace Dt\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use AppBundle\Doctrine\EntityInterface;

/**
 * @ORM\Entity(repositoryClass="Dt\AdminBundle\Repository\AboutUsersRepository")
 * @ORM\Table(name="dt_about_users")
 * 
 * @Gedmo\Tree(type="nested")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * 
 */
class AboutUsers implements Translatable, EntityInterface
{
    
    
    use SoftDeleteableEntity;
    use TimestampableEntity;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column()
     * 
     * @Assert\NotBlank(message="dt_about_user.label.blank", groups={"Profile"})
     * @Assert\Type(type="string", message="dt_about_user.label.type", groups={"Profile"})
     * 
     * @Gedmo\Translatable
     * 
     * @var string
     */
    protected $label;
    
    /**
     * ORM\Column(nullable=true)
     * 
     * Assert\NotBlank(message="dt_about_user.value.blank", groups={"Profile"})
     * Assert\Type(type="string", message="dt_about_user.value.type", groups={"Profile"})
     * 
     * Gedmo\Translatable
     * 
     * @var mixe
     */
    protected $value;
    
    /**
     * @ORM\Column()
     * 
     * @Assert\NotBlank(message="dt_about_user.value_form_type.blank", groups={"Profile"})
     * @Assert\Type(type="string", message="dt_about_user.value_form_type.type", groups={"Profile"})
     * 
     * @var string Value must be a class name who implement \Symfony\Component\Form\FormTypeInterface
     */
    protected $valueFormType;
    
    /**
     * ORM\Column()
     * 
     * Assert\NotBlank(message="dt_about_user.is_value.blank", groups={"Profile"})
     * Assert\Type(type="string", message="dt_about_user.is_value.type", groups={"Profile"})
     * 
     * @var boolean
     */
    protected $isValue;
   
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    protected $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    protected $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    protected $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="AboutUsers")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    protected $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="AboutUsers", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="AboutUsers", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $children;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set label
     *
     * @param string $label
     * @return AboutUser
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
     * Set slug
     *
     * @param string $slug
     * @return AboutUser
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return AboutUser
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set valueFormType
     *
     * @param string $valueFormType
     * @return AboutUser
     */
    public function setValueFormType($valueFormType)
    {
        $this->valueFormType = $valueFormType;

        return $this;
    }

    /**
     * Get valueFormType
     *
     * @return string 
     */
    public function getValueFormType()
    {
        return $this->valueFormType;
    }

    /**
     * Set isValue
     *
     * @param string $isValue
     * @return AboutUser
     */
    public function setIsValue($isValue)
    {
        $this->isValue = $isValue;

        return $this;
    }

    /**
     * Get isValue
     *
     * @return string 
     */
    public function getIsValue()
    {
        return $this->isValue;
    }

    /**
     * Get root
     *
     * @return \Dt\UserBundle\Entity\AboutUser 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \Dt\UserBundle\Entity\AboutUser $parent
     * @return AboutUser
     */
    public function setParent(\Dt\UserBundle\Entity\AboutUser $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Dt\UserBundle\Entity\AboutUser 
     */
    public function getParent()
    {
        return $this->parent;
    }
}

<?php 

namespace Dt\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Dt\UserBundle\Traits\Detail;
use Symfony\Component\Validator\Constraints as Assert;
use Dt\UserBundle\Entity\ProfilePicture;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Type;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\AboutUserRepository")
 * @ORM\Table(name="dt_about_user")
 * 
 * @Gedmo\Tree(type="nested")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * 
 */
class AboutUser implements Translatable
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
     * @ORM\Column(unique=true)
     * 
     * @Gedmo\Slug(fields={"label"})
     * 
     * @var string
     */
    protected $slug;
    
    /**
     * @ORM\Column()
     * 
     * @Assert\NotBlank(message="dt_about_user.value.blank", groups={"Profile"})
     * @Assert\Type(type="string", message="dt_about_user.value.type", groups={"Profile"})
     * 
     * @Gedmo\Translatable
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
     * @var \Symfony\Component\Form\FormTypeInterface
     */
    protected $valueFormType;
    
    /**
     * @ORM\Column()
     * 
     * @Assert\NotBlank(message="dt_about_user.is_value.blank", groups={"Profile"})
     * @Assert\Type(type="string", message="dt_about_user.is_value.type", groups={"Profile"})
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
     * @ORM\ManyToOne(targetEntity="AboutUser")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    protected $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="AboutUser", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="AboutUser", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $children;
    
}

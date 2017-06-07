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
    private $id;
    
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
     * @ORM\Column(nullable=true)
     * @Assert\Choice(callback= "getExpectedReplyTypeArray", groups={"Profile"}, message="dt_about_user.expected_reply_type.choice")
     */
    protected $expectedReplyType;
   
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
    public function setParent(AboutUsers $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Dt\UserBundle\Entity\AboutUsers 
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    

    /**
     * Set expectedReplyType
     *
     * @param string $expectedReplyType
     * @return AboutUsers
     */
    public function setExpectedReplyType($expectedReplyType)
    {
        $this->expectedReplyType = $expectedReplyType;

        return $this;
    }

    /**
     * Get expectedReplyType
     *
     * @return string 
     */
    public function getExpectedReplyType()
    {
        return $this->expectedReplyType;
    }

    public static function getExpectedReplyTypeArray(){
        
        return array(
            '',
            'checkbox', 'radio',
            'text', // One input type
            'textCollection', // 0 à 5 input text
            'textValCollection', // Une liste de valeur saisit dans un champ input
            'textarea'
        );
    }
    
}

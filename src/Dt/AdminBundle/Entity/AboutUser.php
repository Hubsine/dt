<?php 

namespace Dt\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Dt\AdminBundle\Entity\AboutUserMeta;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use AppBundle\Doctrine\EntityInterface;
use Dt\UserBundle\Entity\AboutUserReply;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="Dt\AdminBundle\Repository\AboutUserRepository")
 * @ORM\Table(name="dt_about_user")
 * 
 * @Gedmo\Tree(type="nested")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * 
 * ATTENTION : créer un evenement qui va supprimer dans les AboutUserReply 
 * Si on supprime un AboutUser, il faut le supprimer aussi dans AboutUserReply::responseCheckbox
 * et AboutUserReply::responseRadio. Cela peu se faire avec les evenement doctrine
 * 
 */
class AboutUser implements Translatable, EntityInterface
{
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aboutUserMetas = new ArrayCollection();
    }
    
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
     * @var array
     * 
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Choice(callback= "getExpectedReplyTypeArray", groups={"Profile"}, message="dt_about_user.expected_reply_type.choice")
     * 
     */
    protected $expectedReplyType;
    
    /**
     * @var Dt\UserBundle\Entity\AboutUserReply
     * 
     * ORM\ManyToOne(targetEntity="Dt\UserBundle\Entity\AboutUserReply", cascade={"remove"},
     * inversedBy="responseCheckbox")
     * ORM\JoinColumn(nullable=true)
     */
    protected $aboutUserReplyCheckbox;
    
    /**
     * @var Dt\AdminBundle\Entity\AboutUserMeta
     * 
     * @Assert\Expression(
     *      "this.getExpectedReplyType() in ['radio', 'checkbox'] && !value.isEmpty()",
     *      message="dt_about_user.about_user_metas.expression",
     *      groups={"Profile", "TestAboutUserMetas"}
     * )
     * 
     * @Assert\Valid
     * 
     * @ORM\OneToMany(targetEntity="Dt\AdminBundle\Entity\AboutUserMeta", 
     *      mappedBy="aboutUser", 
     *      cascade={"persist", "remove"})
     * Ne pas oublié de supprimer aussi les reponses lié
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    protected $aboutUserMetas;

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
     * 
     * Assert\Expression(
     *     expression="value !== null && value.getExpectedReplyType() in ['checkbox', 'radio', 'text', 'textCollection', 'textValCollection', 'textarea']",
     *     message="dt_about_user.parent.expression",
     *     groups={"Profile", "TestAboutUserExpectedNotNull"}
     * )
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="AboutUser", mappedBy="parent")
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
    public function setParent(AboutUser $parent = null)
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
    
    

    /**
     * Set expectedReplyType
     *
     * @param string $expectedReplyType
     * @return AboutUser
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
            'checkbox', 'radio',
            'text', // One input type
            'textCollection', // 0 à 5 input text
            'textValCollection', // Une liste de valeur saisit dans un champ input
            'textarea'
        );
    }
    
    /**
     * @Assert\Callback(groups={"Profile", "TestAboutUserExpectedNotNull"})
     */
    public function validate(ExecutionContextInterface $context)
    {
        # - un tree qui a un "expectedReplyType" ne peut pas avoir de child
        if( !empty($this->parent ) && in_array($this->parent->getExpectedReplyType(), self::getExpectedReplyTypeArray()))
        {
            $context
                ->buildViolation("dt_about_user.parent.expression")
                ->atPath('parent')
                ->addViolation();
        }
        
    }
    
    /**
     * Get lvl
     * 
     * @return integer
     */
    public function getLvl(){
        return $this->lvl;
    }
    
    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Add aboutUserMetas
     *
     * @param \Dt\AdminBundle\Entity\AboutUserMeta $aboutUserMeta
     * @return AboutUser
     */
    public function addAboutUserMeta(AboutUserMeta $aboutUserMeta)
    {
        $aboutUserMeta->setAboutUser($this);
        
        $this->aboutUserMetas[] = $aboutUserMeta;

        return $this;
    }

    /**
     * Remove aboutUserMetas
     *
     * @param \Dt\AdminBundle\Entity\AboutUserMeta $aboutUserMeta
     */
    public function removeAboutUserMeta(AboutUserMeta $aboutUserMeta)
    {
        $this->aboutUserMetas->removeElement($aboutUserMeta);
    }

    /**
     * Get aboutUserMetas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAboutUserMetas()
    {
        return $this->aboutUserMetas;
    }

}

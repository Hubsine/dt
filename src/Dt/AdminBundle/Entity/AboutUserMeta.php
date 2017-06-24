<?php

namespace Dt\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @var \Dt\AdminBundle\Entity\AboutUser
     * 
     * @ORM\ManyToOne(targetEntity="Dt\AdminBundle\Entity\AboutUser", 
     *      inversedBy="aboutUserMetas")
     * @ORM\JoinColumn(name="dt_about_user_id", nullable=false)
     * 
     * @Assert\NotBlank(message="dt_about_user_meta.about_user.blank", groups={"Profile"})
     */
    protected $aboutUser;

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

    /**
     * Set aboutUser
     *
     * @param \Dt\AdminBundle\Entity\AboutUser $aboutUser
     * @return AboutUserMeta
     */
    public function setAboutUser(\Dt\AdminBundle\Entity\AboutUser $aboutUser)
    {
        
        $this->aboutUser = $aboutUser;

        
        return $this;
    }

    /**
     * Get aboutUser
     *
     * @return \Dt\AdminBundle\Entity\AboutUser 
     */
    public function getAboutUser()
    {
        return $this->aboutUser;
    }
    
    /**
     * @Assert\Callback(groups={"Profile", "TestAboutUserExpectedIsRadioCheckbox"})
     */
    public function validate(ExecutionContextInterface $context)
    {
        # - le expected de AboutUser doit être radio ou checkbox
        if(!in_array($this->aboutUser->getExpectedReplyType(), array('radio', 'checkbox')))
        {
            $context
                ->buildViolation("dt_about_user_meta.about_user.callback")
                ->atPath('aboutUser')
                ->addViolation();
        }
        
    }
}

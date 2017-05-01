<?php 

namespace Dt\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @ORM\Table(name="dt_user")
 * 
 * @UniqueEntity("phone", message="dt_user.phone.already_used")
 */
class User extends BaseUser
{
    
    public function __construct()
    {
        parent::__construct();
        $this->setRoles(array('ROLE_USER'));
    }
    
    use TimestampableEntity;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @ORM\Column(unique=true, name="slug")
     * @Gedmo\Slug(fields={"username", "id"})
     * @Assert\NotBlank(message="dt_user.slug.blank", groups={"Registration"})
     * 
     * @var string
     */
    protected $slug;
    
    /**
     * @ORM\Column(unique=true, type="integer", name="phone")
     * @Assert\NotBlank(message="dt_user.phone.blank", groups={})
     * 
     * @var integer
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="string", length=10, name="gender")
     * @Assert\Choice(choices = {"male", "female"}, message="dt_user.gender.choice", groups={"Registration"})
     * 
     * @var string
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="date", name="birthday")
     * @Assert\Date(message="dt_user.birthday.date", groups={"Registration"})
     * Assert\NotBlank(message="dt_user.birthday.blank", groups={"Registration"})
     * 
     * @var date
     */
    protected $birthday;
    
    /**
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    protected $facebookAccessToken;
    
        /**
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
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
     * Set phone
     *
     * @param integer $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }
}

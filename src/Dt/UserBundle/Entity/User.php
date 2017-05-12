<?php 

namespace Dt\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Dt\UserBundle\Entity\ProfilePicture;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @ORM\Table(name="dt_user")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
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
     * @ORM\Column(name="first_name", nullable=true)
     * 
     * @Assert\NotBlank(groups={"FbRegistration", "test"}, message="dt_user.first_name.blank")
     * @Assert\Type(type="alpha", groups={"FbRegistration", "test"}, message="dt_user.first_name.type")
     * 
     * @var string
     */
    protected $firstName;
    
    /**
     * @ORM\Column(name="last_name", nullable=true)
     * 
     * @Assert\NotBlank(groups={"FbRegistration"}, message="dt_user.last_name.blank")
     * @Assert\Type(type="alpha", groups={"FbRegistration"}, message="dt_user.last_name.type")
     * 
     * @var string
     */
    protected $lastName;
    
    /**
     * 
     * @ORM\Column(unique=true, name="slug", nullable=false)
     * @Gedmo\Slug(fields={"username", "id"})
     * 
     * @var string
     */
    protected $slug;
    
    /**
     * @ORM\Column(unique=true, type="integer", name="phone", nullable=true)
     * @Assert\NotBlank(message="dt_user.phone.blank", groups={})
     * 
     * @var integer
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="string", length=10, name="gender", nullable=true)
     * 
     * @Assert\Choice(choices = {"male", "female"}, message="dt_user.gender.choice", groups={"Registration", "FbRegistration"})
     * 
     * @var string
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="date", name="birthday", nullable=true)
     * 
     * @Assert\NotBlank(message="dt_user.birthday.blank", groups={"Registration"})
     * @Assert\Date(message="dt_user.birthday.date", groups={"Registration"})
     * @Assert\LessThanOrEqual("-18 years", groups={"Registration"}, message="dt_user.birthday.less_than_or_equal")
     * 
     * @var date
     */
    protected $birthday;
    
    /**
     * ORM\Column(type="string", name="about")
     * 
     * @Assert\NotBlank(groups={""}, message="dt_user.about.blank")
     * @Assert\Type(type="string", groups={""}, message="dt_user.about.type")
     * 
     * @var string
     */
    protected $about;

    /**
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    protected $facebookAccessToken;
    
    /**
     * @ORM\OneToOne(name="profile_picture", targetEntity="Dt\UserBundle\Entity\ProfilePicture", cascade={"persist", "remove"})
     * 
     * @var Dt\UserBundle\Entity\ProfilePicture
     */
    protected $profilePicture;
    
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

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set profilePicture
     *
     * @param \Dt\UserBundle\Entity\ProfilePicture $profilePicture
     * @return User
     */
    public function setProfilePicture(ProfilePicture $profilePicture = null)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return \Dt\UserBundle\Entity\ProfilePicture 
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }
}

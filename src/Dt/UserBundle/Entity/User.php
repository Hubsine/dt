<?php 

namespace Dt\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Dt\UserBundle\Entity\UserPicture;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Type;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="dt_user")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @UniqueEntity("phone", message="dt_user.phone.already_used", groups={"ProfileMoi"})
 * 
 * @ES\Document(type="user")
 */
class User extends BaseUser
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->userPictures = new ArrayCollection();
        $this->setRoles(array('ROLE_USER'));
    }
    
    use SoftDeleteableEntity;
    use TimestampableEntity;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @ES\Id()
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", nullable=true)
     * 
     * @Assert\NotBlank(groups={}, message="dt_user.first_name.blank")
     * @Assert\Type(type="alpha", groups={"FbRegistration", "GoogleRegistration"}, message="dt_user.first_name.type")
     * 
     * @var string
     */
    protected $firstName;
    
    /**
     * @ORM\Column(name="last_name", nullable=true)
     * 
     * @Assert\NotBlank(groups={}, message="dt_user.last_name.blank")
     * @Assert\Type(type="alpha", groups={"FbRegistration", "GoogleRegistration"}, message="dt_user.last_name.type")
     * 
     * @var string
     */
    protected $lastName;
    
    /**
     * 
     * @ORM\Column(unique=true, name="slug", nullable=false)
     * @Gedmo\Slug(fields={"username"})
     * 
     * @var string
     */
    protected $slug;
    
    /**
     * @ORM\Column(unique=true, type="phone_number", name="phone", nullable=true)
     * @Assert\NotBlank(message="dt_user.phone.blank", groups={"ProfileMoi"})
     * @AssertPhoneNumber(message="dt_user.phone.phone_number", defaultRegion="FR", type="mobile", groups={"ProfileMoi"})
     * 
     * @Type("libphonenumber\PhoneNumber")
     * mettre AssertPhoneNumber avec le bundle
     * 
     * @var integer
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="string", length=10, name="gender", nullable=true)
     * 
     * @Assert\Choice(choices = {"male", "female"}, message="dt_user.gender.choice", groups={"ProfileMoi", "Registration", "FbRegistration", "GoogleRegistration"})
     * 
     * @var string
     * 
     * @ES\Property(type="text")
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="date", name="birthday", nullable=true)
     * 
     * @Assert\NotBlank(message="dt_user.birthday.blank", groups={"Registration"})
     * @Assert\Date(message="dt_user.birthday.date", groups={"Registration"})
     * @Assert\LessThanOrEqual("-18 years", groups={"Registration", "ProfileMoi"}, message="dt_user.birthday.less_than_or_equal")
     * 
     * @var date
     */
    protected $birthday;
    
    /**
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     * 
     * @Assert\NotBlank(groups={"FbRegistration"})
     * 
     * @var string 
     */
    protected $facebookId;

    /**
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     * 
     * @Assert\NotBlank(groups={"GoogleRegistration"})
     * 
     * @var string
     */
    protected $googleId;
    
    /**
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Url(
     *      message="dt_user.url.url", 
     *      groups={"ProfileReseauxSociaux"},
     *      protocols = {"http", "https"},
     *      checkDNS = true,
     *      dnsMessage = "dt_user.url.dns")
     * 
     * @var string
     */
    protected $facebookUrl;
    
    /**
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Url(
     *      message="dt_user.url.url", 
     *      groups={"ProfileReseauxSociaux"},
     *      protocols = {"http", "https"},
     *      checkDNS = true,
     *      dnsMessage = "dt_user.url.dns")
     * 
     * @var string
     */
    protected $twitterUrl;
    
    /**
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Url(
     *      message="dt_user.url.url", 
     *      groups={"ProfileReseauxSociaux"},
     *      protocols = {"http", "https"},
     *      checkDNS = true,
     *      dnsMessage = "dt_user.url.dns")
     * 
     * @var string
     */
    protected $instagramUrl;
    
    /**
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Type(
     *      type="string",
     *      message="dt_user.snapchat_name.type",
     *      groups={"ProfileReseauxSociaux"},
     * )
     * 
     * @var string
     */
    protected $snapchatName;

    protected $facebookAccessToken;
    
    protected $googleAccessToken;
    
    /**
     * @Assert\GreaterThanOrEqual(
     *      value=18, 
     *      message="dt_user.age_range.greater_than_or_equal",
     *      groups={"FbRegistration"})
     * 
     * @var integer
     */
    protected $ageRange;

    /**
     * Vérifie que l'adresse gmail est validée par Google pour l'inscription via google
     * 
     * @Assert\IsTrue(message = "dt_user.verified_email.is_true", groups={"GoogleRegistration"})
     * 
     * @var boolean
     */
    protected $verifiedEmail;

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
     * @deprecated 
     * @var type 
     */
    protected $aboutUser;

    /**
     * @deprecated 
     * @var type 
     */
    protected $size; 
    
    /**
     * @ORM\OneToOne(targetEntity="UserPicture")
     * @ORM\JoinColumn(nullable=true)
     * 
     * @var UserPicture
     */
    protected $profilePicture;
    
    /**
     * @var UserLocation
     * 
     * @ORM\OneToOne(targetEntity="UserLocation", cascade={"persist", "remove"}, inversedBy="user")
     * 
     * @Assert\Valid()
     */
    protected $userLocation;

    /**
     * @var UserPicture
     * 
     * @ORM\OneToMany(targetEntity="UserPicture", cascade={"persist", "remove"}, mappedBy="user")
     */
    protected $userPictures;
    
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
     * @param \Dt\UserBundle\Entity\UserPicture $profilePicture
     * @return User
     */
    public function setProfilePicture(UserPicture $profilePicture = null)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return \Dt\UserBundle\Entity\UserPicture 
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }
    
    /**
     * Get ageRange
     * 
     * @return integer
     */
    public function getAgeRange() {
        return $this->ageRange;
    }

    /**
     * Set ageRange 
     * @param integer $ageRange
     * @return User 
     */
    public function setAgeRange($ageRange) {
        $this->ageRange = $ageRange;
        
        return $this;
    }

    /**
     * @param string $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param string $googleAccessToken
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->googleAccessToken = $googleAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->googleAccessToken;
    }
    
    /**
     * Get verifiedEmail
     * 
     * @return boolean
     */
    public function getVerifiedEmail() {
        return $this->verifiedEmail;
    }

    /**
     * @param type $verifiedEmail
     * @return User
     */
    public function setVerifiedEmail($verifiedEmail) {
    
        $this->verifiedEmail = $verifiedEmail;
        
        return $this;
    }

    /**
     * Set facebookUrl
     *
     * @param string $facebookUrl
     * @return User
     */
    public function setFacebookUrl($facebookUrl)
    {
        $this->facebookUrl = $facebookUrl;

        return $this;
    }

    /**
     * Get facebookUrl
     *
     * @return string 
     */
    public function getFacebookUrl()
    {
        return $this->facebookUrl;
    }

    /**
     * Set twitterUrl
     *
     * @param string $twitterUrl
     * @return User
     */
    public function setTwitterUrl($twitterUrl)
    {
        $this->twitterUrl = $twitterUrl;

        return $this;
    }

    /**
     * Get twitterUrl
     *
     * @return string 
     */
    public function getTwitterUrl()
    {
        return $this->twitterUrl;
    }

    /**
     * Set instagramUrl
     *
     * @param string $instagramUrl
     * @return User
     */
    public function setInstagramUrl($instagramUrl)
    {
        $this->instagramUrl = $instagramUrl;

        return $this;
    }

    /**
     * Get instagramUrl
     *
     * @return string 
     */
    public function getInstagramUrl()
    {
        return $this->instagramUrl;
    }

    /**
     * Set snapchatName
     *
     * @param string $snapchatName
     * @return User
     */
    public function setSnapchatName($snapchatName)
    {
        $this->snapchatName = $snapchatName;

        return $this;
    }

    /**
     * Get snapschatName
     *
     * @return string 
     */
    public function getSnapchatName()
    {
        return $this->snapchatName;
    }

    /**
     * Set userLocation
     *
     * @param \Dt\UserBundle\Entity\UserLocation $userLocation
     * @return User
     */
    public function setUserLocation(\Dt\UserBundle\Entity\UserLocation $userLocation = null)
    {
        $this->userLocation = $userLocation;
        
        $userLocation->setUser($this);
        
        return $this;
    }

    /**
     * Get userLocation
     *
     * @return \Dt\UserBundle\Entity\UserLocation 
     */
    public function getUserLocation()
    {
        return $this->userLocation;
    }

    /**
     * Add userPictures
     *
     * @param \Dt\UserBundle\Entity\UserPicture $userPictures
     * @return User
     */
    public function addUserPicture(\Dt\UserBundle\Entity\UserPicture $userPictures)
    {
        $this->userPictures[] = $userPictures;
        
        $userPictures->setUser($this);

        return $this;
    }

    /**
     * Remove userPictures
     *
     * @param \Dt\UserBundle\Entity\UserPicture $userPictures
     */
    public function removeUserPicture(\Dt\UserBundle\Entity\UserPicture $userPictures)
    {
        $this->userPictures->removeElement($userPictures);
    }

    /**
     * Get userPictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserPictures()
    {
        return $this->userPictures;
    }
}

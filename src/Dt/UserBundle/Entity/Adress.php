<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ONGR\ElasticsearchBundle\Annotation as ES;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * Adress
 * 
 * @MappedSuperclass
 * ORM\Table(name="dt_adress")
 * ORM\Entity(repositoryClass="Dt\UserBundle\Repository\AdressRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Adress
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
    protected $id;
    
    /**
     * @var User
     * 
     * @ORM\OneToOne(targetEntity="Dt\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     * 
     * @Assert\Country(message="dt_adress.country.country")
     */
    protected $country;
    
    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    protected $region;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var int
     *
     * @ORM\Column(name="zip_code", type="integer", nullable=true)
     * 
     * @Assert\Length(max = 5, maxMessage="dt_adress.zip_code.length")
     */
    protected $zipCode;


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
     * Set country
     *
     * @param string $country
     * @return Localisation
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Localisation
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Localisation
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set zip
     *
     * @param integer $zip
     * @return Localisation
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return integer 
     */
    public function getZip()
    {
        return $this->zip;
    }
}

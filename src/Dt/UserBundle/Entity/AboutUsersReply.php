<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Dt\AdminBundle\Entity\AboutUsers;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AboutUsersReply
 *
 * @ORM\Table(name="dt_about_users_reply")
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\AboutUsersReplyRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * 
 * Permet d'avoir une seule réponse, pas de duplicata
 * @UniqueEntity(fields={"user", "aboutUsers"}, message="dt_about_users_reply.unique_entity")
 */
class AboutUsersReply
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
     * @var Dt\UserBundle\Entity\User
     * 
     * @ORM\OneToOne(targetEntity="Dt\UserBundle\Entity\User")
     */
    protected $user;
    
    /**
     * Contient un elements de type AboutUsers 
     * 
     * Seul les éléments dont on attend une réponse (AboutUsers::expectedReplyType in [‘checkbox', 'radio', 'text', 'textCollection', 'textValCollection', 'textarea']) sont accépter
     * 
     * @var Dt\AdminBundle\Entity\AboutUsers
     * 
     * @ORM\OneToOne(targetEntity="Dt\AdminBundle\Entity\AboutUsers")
     * 
     * @Assert\Expression(
     *      "value.getExpectedReplyType() in [‘checkbox', 'radio', 'text', 'textCollection', 'textValCollection', 'textarea']",
     *      message="dt_about_users.about_users.expression"
     * )
     */
    protected $aboutUsers;
    
    /**
     * Peut contenir plusieurs éléments de type AboutUsers de derniers niveau (last child) 
     * et dont le AboutUsers::expectedReplyType du parent a la valeur "checkbox"
     * 
     * @var Dt\AdminBundle\Entity\AboutUsers 
     *
     * @ORM\ManyToMany(targetEntity="Dt\AdminBundle\Entity\AboutUsers")
     * @ORM\JoinColumn(nullable=true, name="dt_about_users_reply_checkbox")
     * 
     * @Assert\Expression(
     *      "value.getParent().getExpectedReplyType() == checkbox",
     *      message="dt_about_users_reply.response_checkbox.expression"
     * )
     */
    protected $responseCheckbox;
    
    /**
     * Peut contenir qu'un élément de type AboutUsers de derniers niveau (last child)
     * et dont le AboutUsers::expectedReplyType du parent a la valeur "radio"
     * 
     * Exemple : Yeux > Couleur > Marron
     * -- Marron : est le dernier élèment 
     * -- Couleur : le "expectedReplyType" du parent doit avoir la valeur "radio"
     * 
     * 
     * @var Dt\AdminBundle\Entity\AboutUsers 
     * 
     * @ORM\OneToOne(targetEntity="Dt\AdminBundle\Entity\AboutUsers")
     * @ORM\JoinColumn(nullable=true)
     * 
     * @Assert\Expression(
     *      "value.getParent().getExpectedReplyType() == radio",
     *      message="dt_about_users_reply.response_radio.expression"
     * )
     * 
     */
    protected $responseRadio;
    
    /**
     * @var string
     * 
     * ORM\Column(nullable=true)
     * 
     * @Assert\Type(type="string", message="dt_about_users_reply.response_text.type")
     */
    protected $responseText;
    
    /**
     * @var array Une collection de text input
     * 
     * @ORM\Column(nullable=true, type="array")
     * 
     * 
     * @Assert\Type(type="array", message="dt_about_users_reply.response_text_collection.array")
     * @Assert\Count(
     *      min = 0,
     *      max = 4,
     *      minMessage = "dt_about_users_reply.response_text_collection.count.min",
     *      maxMessage = "dt_about_users_reply.response_text_collection.count.max"
     * )
     * @Assert\Collection(
     *      fields={
     *          "response_0" = @Assert\Optional(
     *                              @Assert\Type(type="string", message="dt_about_users_reply.response_text_collection.string")
     *          ),
     *          "response_1" = @Assert\Optional(
     *                              @Assert\Type(type="string", message="dt_about_users_reply.response_text_collection.string")
     *          ),
     *          "response_2" = @Assert\Optional(
     *                              @Assert\Type(type="string", message="dt_about_users_reply.response_text_collection.string")
     *          ),
     *          "response_3" = @Assert\Optional(
     *                              @Assert\Type(type="string", message="dt_about_users_reply.response_text_collection.string")
     *          ),
     *          "response_4" = @Assert\Optional(
     *                              @Assert\Type(type="string", message="dt_about_users_reply.response_text_collection.string")
     *          )
     *      },
     *      allowMissingFields=true,
     *      extraFieldsMessage="dt_about_users_reply.response_text_collection.extra_fields_message"
     * )
     */
    protected $responseTextCollection = array(
        "response_0" => null, "response_1" => null, "response_2" => null, "response_3" => null, "response_4" => null
    );
    
    /**
     * @var array
     * 
     * @ORM\Column(nullable=true, type="simple_array")
     * 
     * @Assert\Type(type="string", message="dt_about_users_reply.response_text_val_collection.type")
     */
    protected $responseTextValCollection;
    
    /**
     * @var string
     * 
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Type(type="string", message="dt_about_users_reply.response_textarea.type")
     */
    protected $responseTextarea;

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
     * Constructor
     */
    public function __construct()
    {
        $this->responseCheckbox = new ArrayCollection();
    }

    /**
     * Set responseTextCollection
     *
     * @param array $responseTextCollection
     * @return AboutUsersReply
     */
    public function setResponseTextCollection($key, $value)
    {
        $this->responseTextCollection[$key] = $$value;

        return $this;
    }

    /**
     * Get responseTextCollection
     *
     * @return array 
     */
    public function getResponseTextCollection()
    {
        return $this->responseTextCollection;
    }

    /**
     * Set responseTextValCollection
     *
     * @param array $responseTextValCollection
     * @return AboutUsersReply
     */
    public function setResponseTextValCollection($responseTextValCollection)
    {
        $this->responseTextValCollection = $responseTextValCollection;

        return $this;
    }

    /**
     * Get responseTextValCollection
     *
     * @return array 
     */
    public function getResponseTextValCollection()
    {
        return $this->responseTextValCollection;
    }

    /**
     * Set responseTextarea
     *
     * @param string $responseTextarea
     * @return AboutUsersReply
     */
    public function setResponseTextarea($responseTextarea)
    {
        $this->responseTextarea = $responseTextarea;

        return $this;
    }

    /**
     * Get responseTextarea
     *
     * @return string 
     */
    public function getResponseTextarea()
    {
        return $this->responseTextarea;
    }

    /**
     * Set user
     *
     * @param \Dt\UserBundle\Entity\User $user
     * @return AboutUsersReply
     */
    public function setUser(\Dt\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Dt\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set aboutUsers
     *
     * @param \Dt\AdminBundle\Entity\AboutUsers $aboutUsers
     * @return AboutUsersReply
     */
    public function setAboutUsers(\Dt\AdminBundle\Entity\AboutUsers $aboutUsers = null)
    {
        $this->aboutUsers = $aboutUsers;

        return $this;
    }

    /**
     * Get aboutUsers
     *
     * @return \Dt\AdminBundle\Entity\AboutUsers 
     */
    public function getAboutUsers()
    {
        return $this->aboutUsers;
    }

    /**
     * Add responseCheckbox
     *
     * @param \Dt\AdminBundle\Entity\AboutUsers $responseCheckbox
     * @return AboutUsersReply
     */
    public function addResponseCheckbox(\Dt\AdminBundle\Entity\AboutUsers $responseCheckbox)
    {
        $this->responseCheckbox[] = $responseCheckbox;

        return $this;
    }

    /**
     * Remove responseCheckbox
     *
     * @param \Dt\AdminBundle\Entity\AboutUsers $responseCheckbox
     */
    public function removeResponseCheckbox(\Dt\AdminBundle\Entity\AboutUsers $responseCheckbox)
    {
        $this->responseCheckbox->removeElement($responseCheckbox);
    }

    /**
     * Get responseCheckbox
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResponseCheckbox()
    {
        return $this->responseCheckbox;
    }

    /**
     * Set responseRadio
     *
     * @param \Dt\AdminBundle\Entity\AboutUsers $responseRadio
     * @return AboutUsersReply
     */
    public function setResponseRadio(\Dt\AdminBundle\Entity\AboutUsers $responseRadio = null)
    {
        $this->responseRadio = $responseRadio;

        return $this;
    }

    /**
     * Get responseRadio
     *
     * @return \Dt\AdminBundle\Entity\AboutUsers 
     */
    public function getResponseRadio()
    {
        return $this->responseRadio;
    }
}

<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Dt\AdminBundle\Entity\AboutUser;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Doctrine\EntityInterface;

/**
 * AboutUserReply
 *
 * @ORM\Table(name="dt_about_user_reply")
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\AboutUserReplyRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * 
 * Permet d'avoir une seule réponse, pas de duplicata
 * @UniqueEntity(
 *      fields={"user", "aboutUser"}, 
 *      message="dt_about_user_reply.unique_entity",
 *      groups={"AboutUserReply"}
 * )
 */
class AboutUserReply implements EntityInterface
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
     * @ORM\ManyToOne(targetEntity="Dt\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;
    
    /**
     * Contient un elements de type AboutUser 
     * 
     * Seul les éléments dont on attend une réponse (AboutUser::expectedReplyType in [‘checkbox', 'radio', 'text', 'textCollection', 'textValCollection', 'textarea']) sont accépter
     * 
     * @var Dt\AdminBundle\Entity\AboutUser
     * 
     * @ORM\ManyToOne(targetEntity="Dt\AdminBundle\Entity\AboutUser")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Expression(
     *      "value.getExpectedReplyType() in ['checkbox', 'radio', 'text', 'textCollection', 'textValCollection', 'textarea']",
     *      message="dt_about_user.about_user.expression",
     *      groups={"AboutUserReply"}
     * )
     */
    protected $aboutUser;
    
    /**
     * Peut contenir plusieurs éléments de type AboutUserMeta 
     * et dont le AboutUser::expectedReplyType a la valeur "checkbox"
     * 
     * @var Dt\AdminBundle\Entity\AboutUserMeta
     *
     * @ORM\ManyToMany(targetEntity="Dt\AdminBundle\Entity\AboutUserMeta")
     * @ORM\JoinColumn(nullable=true, name="dt_about_user_reply_checkbox")
     * 
     * @Assert\Expression(
     *      "this.getAboutUser().getExpectedReplyType() == 'checkbox'",
     *      message="dt_about_user_reply.response_checkbox.expression",
     *      groups={"checkbox"}
     * )
     */
    protected $responseCheckbox;
    
    /**
     * 
     * @var Dt\AdminBundle\Entity\AboutUserMeta
     * 
     * @ORM\OneToOne(targetEntity="Dt\AdminBundle\Entity\AboutUserMeta")
     * @ORM\JoinColumn(nullable=true, name="about_user_reply_radio")
     * 
     * @Assert\Expression(
     *      "this.getAboutUser().getExpectedReplyType() == 'radio'",
     *      message="dt_about_user_reply.response_radio.expression",
     *      groups={"radio"}
     * )
     * 
     */
    protected $responseRadio;
    
    /**
     * @var string
     * 
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Type(type="string", 
     *      message="dt_about_user_reply.response_text.type", 
     *      groups={"text"})
     */
    protected $responseText;
    
    /**
     * @var array Une collection de text input
     * 
     * @ORM\Column(nullable=true, type="array")
     * 
     * 
     * @Assert\Type(
     *      type="array", 
     *      message="dt_about_user_reply.response_text_collection.array",
     *      groups = {"textCollection"}
     * )
     * Assert\Count(
     *      min = 0,
     *      max = 4,
     *      minMessage = "dt_about_user_reply.response_text_collection.count.min",
     *      maxMessage = "dt_about_user_reply.response_text_collection.count.max",
     *      groups = {"textCollection"}
     * )
     * @Assert\Collection(
     *      fields={
     *          "response_0" = @Assert\Optional(
     *                              @Assert\Type(
     *                                  type="string", 
     *                                  message="dt_about_user_reply.response_text_collection.string",
     *                                  groups={"textCollection"}
     *                              )
     *          ),
     *          "response_1" = @Assert\Optional(
     *                              @Assert\Type(
     *                                  type="string", 
     *                                  message="dt_about_user_reply.response_text_collection.string",
     *                                  groups={"textCollection"}
     *                              )
     *          ),
     *          "response_2" = @Assert\Optional(
     *                              @Assert\Type(
     *                                  type="string", 
     *                                  message="dt_about_user_reply.response_text_collection.string",
     *                                  groups={"textCollection"}
     *                              )
     *          ),
     *          "response_3" = @Assert\Optional(
     *                              @Assert\Type(
     *                                  type="string", 
     *                                  message="dt_about_user_reply.response_text_collection.string",
     *                                  groups={"textCollection"}
     *                              )
     *          ),
     *          "response_4" = @Assert\Optional(
     *                              @Assert\Type(
     *                                  type="string", 
     *                                  message="dt_about_user_reply.response_text_collection.string",
     *                                  groups={"textCollection"}
     *                              )
     *          )
     *      },
     *      allowMissingFields=true,
     *      extraFieldsMessage="dt_about_user_reply.response_text_collection.extra_fields_message",
     *      groups={"textCollection"} 
     *
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
     * @Assert\Type(type="array", 
     *      message="dt_about_user_reply.response_text_val_collection.type",
     *      groups={"textValCollection"})
     */
    protected $responseTextValCollection = array();
    
    /**
     * @var string
     * 
     * @ORM\Column(nullable=true)
     * 
     * Assert\NotBlank( groups = {"textarea"} )
     * @Assert\Type(type="string", 
     *      message="dt_about_user_reply.response_textarea.type",
     *      groups={"textarea"}
     * )
     * 
     * 
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
     * @return AboutUserReply
     */
    public function setResponseTextCollection($responseTextCollection = array())
    {
        $this->responseTextCollection = $responseTextCollection;

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
     * @return AboutUserReply
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
     * @return AboutUserReply
     */
    public function setResponseTextarea($responseTextarea)
    {
        $this->responseTextarea = $responseTextarea;

        return $this;
    }

    /**
     * Set responseText
     * 
     * @param string $text
     * @return $this
     */
    public function setResponseText($text)
    {
        $this->responseText = $text;
        
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
     * Get responseText
     * 
     * @return string
     */
    public function getResponseText()
    {
        return $this->responseText;
    }            

    /**
     * Set user
     *
     * @param \Dt\UserBundle\Entity\User $user
     * @return AboutUserReply
     */
    public function setUser(\Dt\UserBundle\Entity\User $user)
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
     * Set aboutUser
     *
     * @param \Dt\AdminBundle\Entity\AboutUser $aboutUser
     * @return AboutUserReply
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
     * Add responseCheckbox
     *
     * @param \Dt\AdminBundle\Entity\AboutUserMeta $responseCheckbox
     * @return AboutUserReply
     */
    public function addResponseCheckbox(\Dt\AdminBundle\Entity\AboutUserMeta $responseCheckbox)
    {
        $this->responseCheckbox[] = $responseCheckbox;

        return $this;
    }

    /**
     * Remove responseCheckbox
     *
     * @param \Dt\AdminBundle\Entity\AboutUserMeta $responseCheckbox
     */
    public function removeResponseCheckbox(\Dt\AdminBundle\Entity\AboutUserMeta $responseCheckbox)
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
     * @param \Dt\AdminBundle\Entity\AboutUserMeta $responseRadio
     * @return AboutUserReply
     */
    public function setResponseRadio(\Dt\AdminBundle\Entity\AboutUserMeta $responseRadio = null)
    {
        $this->responseRadio = $responseRadio;

        return $this;
    }

    /**
     * Get responseRadio
     *
     * @return \Dt\AdminBundle\Entity\AboutUserMeta 
     */
    public function getResponseRadio()
    {
        return $this->responseRadio;
    }
}

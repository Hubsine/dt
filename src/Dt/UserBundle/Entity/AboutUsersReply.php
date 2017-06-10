<?php

namespace Dt\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AboutUsersReply
 *
 * @ORM\Table(name="about_users_reply")
 * @ORM\Entity(repositoryClass="Dt\UserBundle\Repository\AboutUsersReplyRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
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
     * @ORM\ManyToMany(targetEntity="Dt\AdminBundle\Entity\AboutUsers", 
     * mappedBy="aboutUsersReplyCheckbox")
     * @ORM\JoinColumn(nullable=true)
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
     * @ORM\OneToOne(targetEntity="Dt\AdminBundle\Entity\AboutUsers", 
     * mappedBy="aboutUsersReplyRadio")
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
     * @ORM\Column(nullable=true)
     * 
     * @Assert\Collection(
     *      fields={
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
     *          ),
     *          "response_5" = @Assert\Optional(
     *                              @Assert\Type(type="string", message="dt_about_users_reply.response_text_collection.string")
     *          )
     *      },
     *      allowMissingFields=true,
     *      extraFieldsMessage="dt_about_users_reply.response_text_collection.extra_fields_message"
     * )
     */
    protected $responseTextCollection = array(
        "response_1", "response_2", "response_3", "response_4", "response_5"
    );
    
    /**
     * @var array
     * 
     * @ORM\Column(nullable=true)
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
    
}

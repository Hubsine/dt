<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Dt\AdminBundle\Entity\AboutUser;
use Dt\AdminBundle\Entity\AboutUserMeta;
use Dt\UserBundle\Entity\AboutUserReply;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManager;
use Dt\AdminBundle\Form\DataTransformer\AboutUserToNumberTransformer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use FOS\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use FOS\UserBundle\Doctrine\UserManager;

class AboutUserReplyType extends AbstractType
{

    private $em;
    private $repo;
    private $tokenStorage;
    private $userManager;


    public function __construct(EntityManager $em, TokenStorage $tokenStorage, UserManager $userManager) {
        
        $this->em = $em;
        $this->repo = $this->em->getRepository('DtUserBundle:AboutUserReply');
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $aboutUser = $options['aboutUser'];
        //$aboutUserReplys = $options['aboutUserReplys']; 
        $expectedReplyType = $aboutUser->getExpectedReplyType(); 
       
        $builder
            ->add('user', HiddenType::class, array(
                //'data'  => $this->tokenStorage->getToken()->getUser(),
                //'error_bubbling'   => false,
                //'data_class' => null
            ))
            ->add('aboutUser', HiddenType::class, array(
                //'data' => $aboutUser,
                //'data_class'    => null,
                'invalid_message' => 'That is not a valid issue number',
                //'error_bubbling'   => false
            ));
        
//        $builder->get('aboutUser')->addModelTransformer(new AboutUserToNumberTransformer($this->em));
//        $builder->get('user')->addViewTransformer(new UserToUsernameTransformer($this->userManager));
                                
        switch ($expectedReplyType){
            
            case 'radio':
                $builder->add('responseRadio', EntityType::class, array(
                    'class' => 'DtAdminBundle:AboutUserMeta',
                    'choices'   => $aboutUser->getAboutUserMetas(),
                    'multiple'  => false,
                    'expanded'  => true,
                    'label' => false,
                    'required'  => false,
                    'error_bubbling'   => false,
                    'choice_label'  => function(AboutUserMeta $aboutUserMeta){
                        return $aboutUserMeta->getLabel();
                    }
                ));
                
//                $builder->addEventListener(
//                    FormEvents::POST_SET_DATA, 
//                    function(FormEvent $event) use ($options) {
//                    
//                    
//                });
                break;
            
            case 'checkbox':
                $builder->add('responseCheckbox', EntityType::class, array(
                    'class' => 'DtAdminBundle:AboutUserMeta',
                    'choices'   => $aboutUser->getAboutUserMetas(),
                    'multiple'  => true,
                    'expanded'  => true,
                    'label' => false,
                    'required'  => false,
                    'error_bubbling'   => false,
                    'choice_label'  => function(AboutUserMeta $aboutUserMeta){
                        return $aboutUserMeta->getLabel();
                    }
                ));
                //$builder->get('responseCheckbox')->setData($aboutUserReply->getResponseCheckbox());
                break;
            
            case 'text':
                $builder->add('responseText', TextType::class, array(
                    'label' => false,
                    'required'  => false,
                    'error_bubbling'   => false,
                ));
                break;
            
            case 'textCollection':
                $builder->add('responseTextCollection', CollectionType::class, array(
                    'entry_type'    => TextType::class,
                    'label' => false,
                    'required'  => false,
                    'error_bubbling'   => false,
                    'entry_options' => array(
                        //'label' => false
                    )
                ));
                #$aboutUserReply = new AboutUserReply();
                #$builder->get('responseTextCollection')->setData($aboutUserReply->getResponseTextCollection());
                #$builder->setData($aboutUserReply);
                break;
            
            case 'textValCollection':
                $builder->add('responseTextValCollection', TextType::class, array(
                    'label' => false,
                    'required'  => false,
                    'error_bubbling'   => false,
                ));
                $builder->get('responseTextValCollection')
                    ->addModelTransformer(new CallbackTransformer(
                        function($hasArray){
                            return implode(',', $hasArray);
                        },
                        function($hasString){
                            return explode(',', $hasString);
                        }
                    ));
                break;
            
            case 'textarea':
                $builder->add('responseTextarea', TextareaType::class, array(
                    'label' => false,
                    'required'  => false,
                    'error_bubbling'   => false,
                    #'validation_groups' => array('textarea')
                ));
                break;
        }
        
        
//        $builder->addEventListener(
//            FormEvents::PRE_SUBMIT, 
//            function(FormEvent $event) use($user){
//                 
//                $aboutUserReplys = $event->getData();
//                //$aboutUserReplys['user'] = $user;
//                //$AboutUserReplys
//                $event->setData($aboutUserReplys);
//                echo gettype($aboutUserReplys);
//                
//                
//            }
//        );
        
//        $aboutUserReply = new AboutUserReply();
//        foreach ($aboutUser->getAboutUserMetas() as $key => $aboutUserMeta) {
//            $aboutUserReply->addResponseCheckbox($aboutUserMeta);
//        }
//        $builder->setData($aboutUserReply);
        
        $builder->get('aboutUser')->addModelTransformer(new AboutUserToNumberTransformer($this->em));
        $builder->get('user')->addViewTransformer(new UserToUsernameTransformer($this->userManager));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\AboutUserReply',
            'node'  => null,
            'aboutUser' => null,
            'aboutUserReplys'   => null,
            //'validation_groups' => array('AboutUserReply')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_userbundle_aboutuserreply';
    }


}

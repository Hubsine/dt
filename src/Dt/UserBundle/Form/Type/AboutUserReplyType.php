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

class AboutUserReplyType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $aboutUser = $options['aboutUser'];
        $aboutUserReplys = $options['aboutUserReplys']; 
        $expectedReplyType = $aboutUser->getExpectedReplyType(); 
       
        $builder
            ->add('aboutUser', HiddenType::class, array(
                'data' => $aboutUser->getId()
            ));
                                
        switch ($expectedReplyType){
            
            case 'radio':
                $builder->add('responseRadio', EntityType::class, array(
                    'class' => 'DtAdminBundle:AboutUserMeta',
                    'choices'   => $aboutUser->getAboutUserMetas(),
                    'multiple'  => false,
                    'expanded'  => true,
                    'label' => false,
                    'choice_label'  => function(AboutUserMeta $aboutUserMeta){
                        return $aboutUserMeta->getLabel();
                    }
                ));
                
                $builder->addEventListener(
                    FormEvents::POST_SET_DATA, 
                    function(FormEvent $event) use ($options) {
                    
                    
                });
                break;
            
            case 'checkbox':
                $builder->add('responseCheckbox', EntityType::class, array(
                    'class' => 'DtAdminBundle:AboutUserMeta',
                    'choices'   => $aboutUser->getAboutUserMetas(),
                    'multiple'  => true,
                    'expanded'  => true,
                    'label' => false,
                    'choice_label'  => function(AboutUserMeta $aboutUserMeta){
                        return $aboutUserMeta->getLabel();
                    }
                ));
                //$builder->get('responseCheckbox')->setData($aboutUserReply->getResponseCheckbox());
                break;
            
            case 'text':
                $builder->add('responseText', TextType::class, array(
                    'label' => false
                ));
                break;
            
            case 'textCollection':
                $builder->add('responseTextCollection', CollectionType::class, array(
                    'entry_type'    => TextType::class,
                    'label' => false,
                    'required'  => false,
                    'data'  => array("response_0" => null, "response_1" => null, "response_2" => null, 
                        "response_3" => null, "response_4" => null),
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
                    'label' => false
                ));
//                $builder->get('responseTextValCollection')
//                    ->addModelTransformer(new CallbackTransformer(
//                        function($hasArray){
//                            return implode(',', $hasArray);
//                        },
//                        function($hasString){
//                            return explode(',', $hasString);
//                        }
//                    ));
                break;
            
            case 'textarea':
                $builder->add('responseTextarea', TextareaType::class, array(
                    'label' => false
                ));
                break;
        }
        
//        $aboutUserReply = new AboutUserReply();
//        foreach ($aboutUser->getAboutUserMetas() as $key => $aboutUserMeta) {
//            $aboutUserReply->addResponseCheckbox($aboutUserMeta);
//        }
//        $builder->setData($aboutUserReply);
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
            'aboutUserReplys'   => null
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

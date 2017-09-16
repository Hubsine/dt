<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\CallbackTransformer;

class UserParametersType extends AbstractType
{
    
    /** Request $request */
    private $request;
    
    public function __construct(RequestStack $request) 
    {
        $this->request = $request;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sectionData = $this->request->getCurrentRequest()->get('sectionData');
        $optionsResolver = new OptionsResolver();
        
        //$sectionData = ( is_array($sectionData) ) ? $sectionData : (array) rawurldecode($sectionData);
        
        //var_dump($sectionData);
        //die()
        switch ($sectionData['contentId'])
        {
            case 'userParametersPasswordContent':
                ###
                # Password
                ###
                $builder->add('plainPassword', ChangePasswordFormType::class, array(
                    'label' => false,
                    'required'  => false
                ));
            break;
        
            case 'userParametersEmailContent':
                ###
                # Email
                ###
                $builder->add('email', RepeatedType::class, array(
                    'translation_domain' => 'FOSUserBundle',
                    'type'  => EmailType::class,
                    'first_options' => array('label' => 'form.email'),
                    'second_options' => array('label' => 'form.email_confirmation'),
                    'invalid_message' => 'dt_user.email.mismatch',
                    'required'  => false
                    )
                );
                //$this->configureOptions($optionsResolver->setDefault('validation_groups', array('ChangeEmail')));
            break;
        }
        
//        $builder->add('sectionData', HiddenType::class, array(
//            'data'=> $sectionData, 
//            'mapped'=> false,
//        ));
//        
//        $builder->get('sectionData')
//            ->addModelTransformer(new CallbackTransformer(
//                function($hasArray){
//                    return implode(',', $hasArray);
//                },
//                function($hasString){
//                    return explode(',', $hasString);
//                }
//        ));
        
        $builder->add('container', HiddenType::class, array(
            'data' => $sectionData['contentId'],
            'mapped'    => false
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\User',
            'allow_extra_fields'    => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_userbundle_user';
    }


}

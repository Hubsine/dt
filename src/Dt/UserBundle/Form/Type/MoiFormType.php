<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Dt\UserBundle\Entity\User;

class MoiFormType extends AbstractType
{
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', TextType::class, 
                    array(
                        'label' => 'form.username',
                        'required'  => true
                    )
                )
                ->add('birthday', BirthdayType::class,
                    array(
                        'label' => 'form.birthday', 
                        'required'  => true,
                        'placeholder' => array(
                            'year' => 'form.year', 'month' => 'form.month', 'day' => 'form.day'
                        )
                    )
                )
                ->add('phone', PhoneNumberType::class, 
                    array(
                        'label' => 'form.phone',
                        'format' => PhoneNumberFormat::INTERNATIONAL,
                        'default_region' => 'FR',
                        'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE, 
                        'country_choices' => array('GB', 'JE', 'FR', 'US'), 
                        'preferred_country_choices' => array('FR')
                    )
                )
                ->add('gender', ChoiceType::class,
                    array(
                        'label' => 'form.gender',
                        'required'  => true,
                        'expanded'  => true,
                        'multiple'  => false,
                        'choices_as_values' => true,
                        'choice_attr' => function($val, $key, $index) {
                            // adds a class like attending_yes, attending_no, etc
                            return ['class' => ''];
                        },
                        'choices'  => array('form.gender_male' => 'male', 'form.gender_female' => 'female')
                    )
                );
        
//        $builder->get('username')
//                ->addModelTransformer($options['usernameTransformer']);
                
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups' => array('ProfileMoi'),
            'usernameTransformer'   => null,
            'translation_domain'    => 'FOSUserBundle'
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

<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class RegistrationFormType extends AbstractType
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
                            #'label_attr'    => array('class' => 'label-control'),
                            'translation_domain' => 'FOSUserBundle',
                            'required'  => false
                            )
                        )
                ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), 
                        array(
                            'translation_domain' => 'FOSUserBundle',
                            'type'  => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'),
                            'first_options' => array('label' => 'form.email'),
                            'second_options' => array('label' => 'form.email_confirmation'),
                            'invalid_message' => 'dt_user.email.mismatch',
                            'required'  => false
                            )
                        )    
                ->add('birthday', BirthdayType::class, 
                        array(
                            'translation_domain' => 'FOSUserBundle',
                            'label' => 'form.birthday', 
                            'required'  => false,
                            'placeholder' => array(
                                'year' => 'form.year', 'month' => 'form.month', 'day' => 'form.day'
                            )
                        ))
                ->add('gender', ChoiceType::class,
                        array(
                            'translation_domain' => 'FOSUserBundle',
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
                        ))
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\User'
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

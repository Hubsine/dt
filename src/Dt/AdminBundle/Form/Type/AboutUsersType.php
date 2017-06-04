<?php

namespace Dt\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AboutUsersType extends AbstractType
{
    public static $valueFormType = array(
        'RadioType' => RadioType::class, 
        'CheckboxType' => CheckboxType::class, 
        'TextType' => TextType::class,
        'CollectionType'   => CollectionType::class
    );
            
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('label', TextType::class, array(
                    'label' => 'form.about_users.label.label',
                    'required'  => true
                ))
                ->add('valueFormType', ChoiceType::class, array(
                    'label' => 'about_users.value_form_type.label',
                    'help_block'    => 'form.about_users.value_form_type.help_text',
                    'required'  => true,
                    'choices'   => AboutUsersType::$valueFormType,
                    'choices_as_values' => true
                ))
                ->add('parent', EntityType::class, array(
                    'label' => 'form.about_users.parent.label',
                    'required'  =>  false,
                    'class' => 'DtAdminBundle:AboutUsers',
                    'choice_label'  => 'label',
                    'multiple'  => false,
                    'expanded'  => false
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\AdminBundle\Entity\AboutUsers',
            'validation_groups' => array('Profile'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_adminbundle_aboutusers';
    }


}

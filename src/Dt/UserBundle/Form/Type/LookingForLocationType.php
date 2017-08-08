<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LookingForLocationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', CountryType::class, array(
                'label' => 'form.country'
            ))
            ->add('region', TextType::class, array(
                'label' => 'form.region',
                'required'  => false
            ))
            ->add('city', TextType::class, array(
                'label' => 'form.city',
                'required'  => false
            ))
            ->add('zipCode', IntegerType::class, array(
                'label' => 'form.zip_code',
                'required'  => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\LookingForLocation',
            'translation_domain' => 'FOSUserBundle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_userbundle_lookingforlocation';
    }


}

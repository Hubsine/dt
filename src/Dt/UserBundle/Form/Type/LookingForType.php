<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Dt\AdminBundle\Entity\LookingForMeta;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LookingForType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lookingForMeta', EntityType::class, array(
                'class' => LookingForMeta::class,
                'multiple'  => true,
                'expanded'  => true,
                'choice_label'  => function ($lookingForMeta){
                    return $lookingForMeta->getLabel();
                }
            ))
            ->add('ageRange')->add('location');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\LookingFor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_userbundle_lookingfor';
    }


}

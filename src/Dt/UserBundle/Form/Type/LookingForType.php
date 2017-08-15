<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Dt\AdminBundle\Entity\LookingForMeta;
use Dt\UserBundle\Entity\LookingForLocation;
use Dt\AdminBundle\Repository\LookingForMetaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Dt\UserBundle\Form\Type\LookingForLocationType;

class LookingForType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genders', EntityType::class, array(
                'label' => 'form.genders',
                'class' => LookingForMeta::class,
                'multiple'  => true,
                'expanded'  => true,
                'choice_label'  => function ($lookingForMeta){
                    return $lookingForMeta->getLabel();
                },
                'query_builder' => function (LookingForMetaRepository $er) {
                    return $er->createQueryBuilder('l')
                            ->where('l.onProperty = :onProperty')
                            ->setParameter('onProperty', 'genders');
                }
            ))
            ->add('relationships', EntityType::class, array(
                'label' => 'form.relationships',
                'class' => LookingForMeta::class,
                'multiple'  => true,
                'expanded'  => true,
                'choice_label'  => function ($lookingForMeta){
                    return $lookingForMeta->getLabel();
                },
                'query_builder' => function (LookingForMetaRepository $er) {
                    return $er->createQueryBuilder('l')
                            ->where('l.onProperty = :onProperty')
                            ->setParameter('onProperty', 'relationships');
                }        
            ))
//            ->add('ageRange', RangeType::class, array(
//                'attr'  => $builder->getData()->getAgeRange(),
//                //'type'    => 'range'
//                //'data'  => $builder->getData()->getAgeRange()
//            ))
            ->add('location', LookingForLocationType::class, array(
                'label' => 'form.location'
                //'class' => LookingForLocation::class
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\LookingFor',
            'translation_domain' => 'FOSUserBundle'
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

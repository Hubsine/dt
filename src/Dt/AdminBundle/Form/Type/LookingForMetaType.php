<?php

namespace Dt\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Dt\AdminBundle\Entity\LookingForMeta;

class LookingForMetaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, array(
                'label' => '',
                'required'  => true
            ))
            ->add('onProperty', ChoiceType::class, array(
                'label' => '',
                'required'  => true,
                'choices'   => LookingForMeta::getAvaiblesOnProperty(),
                'choices_as_values' => true,
                'choice_label' => function ($value, $key, $index) {
                    return $value;
                }
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\AdminBundle\Entity\LookingForMeta'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_adminbundle_lookingformeta';
    }


}

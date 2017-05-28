<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReseauxSociauxFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('facebookUrl', UrlType::class, array(
                'label' => 'form.facebook_url',
                'required'  => false
            ))
            ->add('twitterUrl', UrlType::class, array(
                'label' => 'form.twitter_url',
                'required'  => false
            ))
            ->add('instagramUrl', UrlType::class, array(
                'label' => 'form.instagram_url',
                'required'  => false
            ))
            ->add('snapchatName', TextType::class, array(
                'label' => 'form.snapchat_name',
                'required'  => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\User',
            'validation_groups' => array('ProfileReseauxSociaux'),
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

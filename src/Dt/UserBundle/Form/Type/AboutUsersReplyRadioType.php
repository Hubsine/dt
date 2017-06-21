<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Dt\AdminBundle\Entity\AboutUser;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AboutUserReplyRadioType extends AbstractType
{

    private $choices;
    
    public function __construct(array $choices) {
        $this->choices = $choices;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $builder
            ->add('aboutUser', EntityType::class, array(
                    'class' => 'DtAdminBundle:AboutUser',
                    'choice_label'  => function(AboutUser $aboutUser){
                        return $aboutUser->getLabel();
                    },
            ))
            ->add('responseRadio', EntityType::class, array(
                'class' => 'DtAdminBundle:AboutUser',
                'multiple'  => false,
                'expanded'  => true,
                'choices'   => $this->choices
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\AboutUserReply'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_userbundle_aboutusersradioreply';
    }


}

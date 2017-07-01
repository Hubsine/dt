<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Dt\AdminBundle\Entity\AboutUser;
use Dt\AdminBundle\Entity\AboutUserMeta;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AboutUserReplyType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $aboutUser = $options['aboutUser'];
        $expectedReplyType = $aboutUser->getExpectedReplyType(); 
        
        $builder
            ->add('aboutUser', HiddenType::class, array(
                'data' => $aboutUser->getId()
            ));
                                
        switch ($expectedReplyType){
            
            case 'radio':
                $builder->add('responseRadio', EntityType::class, array(
                    'class' => 'DtAdminBundle:AboutUserMeta',
                    'choices'   => $aboutUser->getAboutUserMetas(),
                    'multiple'  => false,
                    'expanded'  => true,
                    'label' => false,
                    'choice_label'  => function(AboutUserMeta $aboutUserMeta){
                        return $aboutUserMeta->getLabel();
                    }
                ));
                break;
            
            case 'checkbox':
                $builder->add('responseCheckbox', EntityType::class, array(
                    'class' => 'DtAdminBundle:AboutUserMeta',
                    'choices'   => $aboutUser->getAboutUserMetas(),
                    'multiple'  => true,
                    'expanded'  => true,
                    'label' => false,
                    'choice_label'  => function(AboutUserMeta $aboutUserMeta){
                        return $aboutUserMeta->getLabel();
                    }
                ));
                break;
            
            case 'text':
                $builder->add('responseText', TextType::class, array(
                    'label' => false
                ));
                break;
            
            case 'textCollection':
                $builder->add('responseTextCollection', CollectionType::class, array(
                    'entry_type'    => TextType::class,
                    'label' => false,
                    'entry_options' => array(
                        'data'  => array('test', 'test2')
                    )
                ));
                break;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\AboutUserReply',
            'node'  => null,
            'aboutUser' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_userbundle_aboutuserreply';
    }


}

<?php

namespace Dt\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Dt\AdminBundle\Entity\AboutUser;

class AboutUserMetaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, array(
                'label' => 'form.about_user_meta.label.label',
                'required'  => true
            ))
            ->add('aboutUser', EntityType::class, array(
                'label' => 'form.about_user_meta.about_user.label',
                'required'  => true,
                'class' => 'DtAdminBundle:AboutUser',
                'choice_attr' => function($val, $key, $index) {
                    
                    $attributes = array();
                    if(!in_array($val->getExpectedReplyType(), array('radio', 'checkbox')))
                    {
                        $attributes['disabled'] = 'disabled';
                    }
                    return $attributes;
                },
                'choice_label'  => function(AboutUser $aboutUser){
                        
                    $prefix = str_repeat('-', $aboutUser->getLvl());

                    return $prefix . ' ' . $aboutUser->getLabel();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('node')
                        #->where('node.expectedReplyType = :expectedReplyTypeRadio')
                        #->setParameter('expectedReplyTypeRadio', 'radio')
                        #->orWhere('node.expectedReplyType = :expectedReplyTypeCheckbox')
                        #->setParameter('expectedReplyTypeCheckbox', 'checkbox')
                        ->orderBy('node.root, node.lft', 'ASC')
                        ;
                },
            ))
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\AdminBundle\Entity\AboutUserMeta',
            'validation_groups' => array('Profile')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_adminbundle_aboutusermeta';
    }


}

<?php

namespace Dt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Dt\AdminBundle\Entity\AboutUsers;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AboutUsersReplyType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $builder->add('aboutUsers', EntityType::class, 
            array(
                'class' => 'DtAdminBundle:AboutUsers',
                'choice_label'  => function(AboutUsers $aboutUsers){
                    return $aboutUsers->getLabel();
                },
//                'multiple'  => false,
//                'expanded'  => false,
//                'query_builder' => function(EntityRepository $er){
//
//                    return $er
//                            ->createQueryBuilder('node')
//                            ->orderBy('node.root, node.lft', 'ASC');
//                }
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dt\UserBundle\Entity\AboutUsersReply'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dt_userbundle_aboutusersreply';
    }


}

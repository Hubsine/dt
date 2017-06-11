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
use Dt\AdminBundle\Entity\AboutUsers;
use AppBundle\Form\Tree\TreeType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;;

class AboutUsersType extends AbstractType
{
    
    private $em;
    private $repo;
            
    public function __construct(EntityManager $em) {
        
        $this->em = $em;
        $this->repo = $this->em->getRepository('DtAdminBundle:AboutUsers');
    }

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
                ->add('expectedReplyType', ChoiceType::class, array(
                    'label' => 'form.about_users.expected_reply_type.label',
                    'help_block'    => 'form.about_users.expected_reply_type.help_text',
                    'required'  => false,
                    'choices'   => AboutUsers::getExpectedReplyTypeArray(),
                    'choices_as_values' => true,
                    'multiple'  => false,
                    'expanded'  => true,
                    'choice_label'  => function($value, $key, $index){
                        if($value == null){
                            return 'Null';
                        }else{
                            return $value;
                        }
                    }
                ))
                ->add('parent', EntityType::class, array(
                    'label' => 'form.about_users.parent.label',
                    'required'  =>  false,
                    'class' => 'DtAdminBundle:AboutUsers',
                    'choice_label'  => function(AboutUsers $aboutUsers){
                        
                        $prefix = str_repeat('-', $aboutUsers->getLvl());
                        
                        return $prefix . ' ' . $aboutUsers->getLabel();
                    },
                    'multiple'  => false,
                    'expanded'  => false,
                    'query_builder' => function(EntityRepository $er){
                        
                        return $er
                                ->createQueryBuilder('node')
                                ->orderBy('node.root, node.lft', 'ASC');
                    }
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

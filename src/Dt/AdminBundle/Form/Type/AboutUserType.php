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
use Dt\AdminBundle\Entity\AboutUser;
use Dt\AdminBundle\Form\Type\AboutUserMetaType;
use AppBundle\Form\Tree\TreeType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class AboutUserType extends AbstractType
{
    
    private $em;
    private $repo;
            
    public function __construct(EntityManager $em) {
        
        $this->em = $em;
        $this->repo = $this->em->getRepository('DtAdminBundle:AboutUser');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('label', TextType::class, array(
                    'label' => 'form.about_user.label.label',
                    'required'  => true
                ))
                ->add('expectedReplyType', ChoiceType::class, array(
                    'label' => 'form.about_user.expected_reply_type.label',
                    'help_block'    => 'form.about_user.expected_reply_type.help_text',
                    'required'  => false,
                    'choices'   => AboutUser::getExpectedReplyTypeArray(),
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
                ->add('aboutUserMetas', CollectionType::class, array(
                    'entry_type'    => AboutUserMetaType::class,
                    'allow_add' => true,
                    'allow_delete'  => true,
                    'by_reference'  => false,
                    'error_bubbling'    => false
                ))
                ->add('parent', EntityType::class, array(
                    'label' => 'form.about_user.parent.label',
                    'required'  =>  false,
                    'class' => 'DtAdminBundle:AboutUser',
                    'choice_label'  => function(AboutUser $aboutUser){
                        
                        $prefix = str_repeat('-', $aboutUser->getLvl());
                        
                        return $prefix . ' ' . $aboutUser->getLabel();
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
            'data_class' => 'Dt\AdminBundle\Entity\AboutUser',
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

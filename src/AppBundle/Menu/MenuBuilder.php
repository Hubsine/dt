<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;

/**
 * Description of MenuBuilder
 *
 * @author Hubsine
 */
class MenuBuilder{

    /**
     * @var FactoryInterface
     */
    private $factory;
    
    /**
     * @var TokenStorage
     */
    private $securityTokenStorage;
    
    /**
     * @var Request
     */
    private $requestStack;
    
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    public $userId;


    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, TokenStorage $securityTokenStorage, RequestStack $requestStack) {
        
        $this->factory = $factory;
        $this->securityTokenStorage = $securityTokenStorage;
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getCurrentRequest();
        
        $user = $this->securityTokenStorage->getToken()->getUser();
        
        // anon.
        if($user instanceof UserInterface){
            $this->userId = $this->securityTokenStorage->getToken()->getUser()->getId();
        }else{
            $this->userId = 'anon.';
        }
        
    }

    public function createMainMenu(array $options){
        
        $menu = $this->factory->createItem('root', array(
            'navbar' => true,
        ));

        $menu->addChild('members', array(
            'icon' => 'users',
            'route' => 'dt_user_members'
        ))->setExtra('translation_domain', 'menu');
        
        $menu->addChild('my_profile', array(
            'route' => 'fos_user_profile_show', // Il s'agit de montrer le profile public que tout le monde peut voir
            'routeParameters'   => array('id' => $this->userId)
        ))->setExtra('translation_domain', 'menu');

        $menu->addChild('demandes', array(
            'route' => 'dt_user_members_history',
            'routeParameters'   => array('id' => $this->userId)
        ))->setExtra('translation_domain', 'menu');

        return $menu;
        
    }
    
    public function createLogoutMenu(array $options){
        
        $menu = $this->factory->createItem('accueil');
        
        $menu->addChild('login', array(
            'route' => 'fos_user_security_login'
        ))->setExtra('translation_domain', 'menu');
        
        $menu->addChild('inscription', array(
           'route'  => 'fos_user_registration_register' 
        ))->setExtra('translation_domain', 'menu');
        
        return $menu;
    }
    
    public function createLoginMenu(array $options){
        
        $menu = $this->factory->createItem('accueil', array(
            'route' => 'homepage'
        ))->setExtra('translation_domain', 'menu');
        
        $menu->addChild('my_profile', array(
            'icon'  => 'user',
            'route' => 'fos_user_profile_show', // Il s'agit de montrer le profile public que tout le monde peut voir
            'routeParameters'   => array('id' => $this->userId)
        ))->setExtra('translation_domain', 'menu');
        
        $menu->addChild('mon_compte', array(
            'icon' => 'cog',
            'caret' => true, 
            'route' => 'dt_user_members_mon_compte',
            'routeParameters'   => array('id' => $this->userId)
        ))->setExtra('translation_domain', 'menu');
        
        
//        $profil->addChild('profile', array(
//            'route' => 'fos_user_profile_show',
//            'routeParameters'   => array('id' => $this->userId)
//        ))->setExtra('translation_domain', 'menu');
//        
//        $profil->addChild('mes_demandes', array(
//            'route' => 'dt_user_members_history',
//            'routeParameters'   => array('id' => $this->userId)
//        ))->setExtra('translation_domain', 'menu');
//        
//        $profil->addChild('parametres', array(
//            'route' => 'dt_user_members_mon_compte',
//            'routeParameters'   => array('id' => $this->userId)
//        ))->setExtra('translation_domain', 'menu');
//        
//        $profil->addChild('logout', array(
//            'route' => 'fos_user_security_logout'
//        ))->setExtra('translation_domain', 'menu');
        
        return $menu;
    }
    
    public function createSidebarMenu(array $options){
        
        $tab = $this->request->query->get('tab', 'profile');
        
        $menu = $this->factory->createItem('sidebar.accueil', array(
            #'childrenAttributes'    => array('class', 'hidden-print hidden-sm hidden-xs affix')
        ))->setAttribute('class', 'hidden-print hidden-sm hidden-xs');
        
        ###
        # Profile 
        ###
        $profile = $menu->addChild('sidebar.profile', array(
        ))
            ->setExtra('translation_domain', 'menu')
            ->setUri('?tab=profile')
            ->setChildrenAttribute('class', 'nav hasSubLi');
        
        if($tab === 'profile'){
            
            $profile->setCurrent(true);
            
            $profile->addChild('sidebar.moi', array(
            ))
                ->setExtra('translation_domain', 'menu')
                ->setUri('#profile-moi')
                ->setAttribute('class', 'active');    
            
            $profile->addChild('sidebar.reseaux_sociaux', array(
            ))
                ->setExtra('translation_domain', 'menu')
                ->setUri('#profile-reseaux-sociaux');
            
            $profile->addChild('sidebar.about', array(
            ))
                ->setExtra('translation_domain', 'menu')
                ->setUri('#profile-a-propos-de-moi');
            
            $profile->addChild('sidebar.cherche', array(
            ))
               ->setExtra('translation_domain', 'menu')
               ->setUri('#profile-je-cherche');
            
            $profile->addChild('sidebar.localisation', array(
            ))
                ->setExtra('translation_domain', 'menu')
                ->setUri('#profile-localisation');
        }
        
        ###
        # Matching
        ###
//        $matching = $menu->addChild('sidebar.matching', array(
//        ))
//                ->setExtra('translation_domain', 'menu')
//                ->setUri('?tab=matching')
//                ->setChildrenAttribute('class', 'nav hasSubLi');
//        
//        if($tab === 'matching'){
//            
//            $matching->setCurrent(true);
//            
//            $matching->addChild('sidebar.qui', array(
//            ))
//                ->setExtra('translation_domain', 'menu')
//                ->setUri('#matching-qui-suis-je')
//                ->setAttribute('class', 'active');
//            
//            $matching->addChild('sidebar.cherche', array(
//            ))
//               ->setExtra('translation_domain', 'menu')
//               ->setUri('#matching-je-cherche');
//        }
        
        ###
        # Photos
        ###
        $photos = $menu->addChild('sidebar.photos', array(
        ))
            ->setExtra('translation_domain', 'menu')
            ->setUri('?tab=photos');
        
        ###
        # Parametres menu 
        ###
        $parametres = $menu->addChild('sidebar.parameters', array(
        ))
                ->setExtra('translation_domain', 'menu')
                ->setUri('?tab=parametres')
                ->setChildrenAttribute('class', 'nav hasSubLi');
        
        if($tab === 'parametres'){
            
            $parametres->setCurrent(true);
            
            $parametres->addChild('sidebar.password', array(
            ))->setExtra('translation_domain', 'menu')->setUri('#parameters-password')->setAttribute('class', 'active');
            $parametres->addChild('sidebar.email', array(
            ))->setExtra('translation_domain', 'menu')->setUri('#parameters-email');
            $parametres->addChild('sidebar.autorisation', array(
            ))->setExtra('translation_domain', 'menu')->setUri('#parameters-autorisation');
            $parametres->addChild('sidebar.delete_compte', array(
            ))->setExtra('translation_domain', 'menu')->setUri('#parameters-delete');
        }
        return $menu;
    }
}

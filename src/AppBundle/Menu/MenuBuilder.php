<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Description of MenuBuilder
 *
 * @author Hubsine
 */
class MenuBuilder {

    /**
     * @var FactoryInterface
     */
    private $factory;
    
    /**
     * @var TokenStorage
     */
    private $securityTokenStorage;

    /**
     * @var string
     */
    public $usernameSlug;


    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, TokenStorage $securityTokenStorage) {
        
        $this->factory = $factory;
        $this->securityTokenStorage = $securityTokenStorage;
        
        if($this->securityTokenStorage->getToken()->getUser()){
            $this->usernameSlug = $this->securityTokenStorage->getToken()->getUser();
        }else{
            $this->usernameSlug = null;
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
            'routeParameters'   => array('username' => $this->usernameSlug)
        ))->setExtra('translation_domain', 'menu');

        $menu->addChild('demandes', array(
            'route' => 'dt_user_members_history',
            'routeParameters'   => array('username' => $this->usernameSlug)
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
        
        $profil = $menu->addChild('mon_compte', array(
            'icon' => 'user',
            'caret' => true, 
            'route' => 'dt_user_members_mon_compte',
            'routeParameters'   => array('username' => $this->usernameSlug)
        ))->setExtra('translation_domain', 'menu');
        
//        $profil->addChild('profile', array(
//            'route' => 'fos_user_profile_show',
//            'routeParameters'   => array('username' => $this->usernameSlug)
//        ))->setExtra('translation_domain', 'menu');
//        
//        $profil->addChild('mes_demandes', array(
//            'route' => 'dt_user_members_history',
//            'routeParameters'   => array('username' => $this->usernameSlug)
//        ))->setExtra('translation_domain', 'menu');
//        
//        $profil->addChild('parametres', array(
//            'route' => 'dt_user_members_mon_compte',
//            'routeParameters'   => array('username' => $this->usernameSlug)
//        ))->setExtra('translation_domain', 'menu');
//        
//        $profil->addChild('logout', array(
//            'route' => 'fos_user_security_logout'
//        ))->setExtra('translation_domain', 'menu');
        
        return $menu;
    }
    
    public function createSidebarMenu(array $options){
        
        $menu = $this->factory->createItem('accueil', array(
            'attributes' => array('class' => 'nav')
        ));
        
        $profile = $menu->addChild('profile')->setUri('#');
        
        $profile->addChild('photos', array(
            
        ))->setExtra('translation_domain', 'menu')->setUri('#');
        
        
        /// Parametres menu 
        $parametres = $menu->addChild('parameters', array(
        ))->setExtra('translation_domain', 'menu')->setUri('#parametres');
        
        $parametres->addChild('password', array(
            
        ))->setExtra('translation_domain', 'menu')->setUri('#parameters-password');
        
        $parametres->addChild('email', array(
            
        ))->setExtra('translation_domain', 'menu')->setUri('#parameters-email');
        
        $parametres->addChild('autorisation', array(
            
        ))->setExtra('translation_domain', 'menu')->setUri('#parameters-autorisation');
        
        $parametres->addChild('delete_compte', array(
            
        ))->setExtra('translation_domain', 'menu')->setUri('#parameters_delete');
        
        return $menu;
    }
}

<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

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
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory) {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options){
        
        $menu = $this->factory->createItem('root', array(
            'navbar' => true,
        ));

        $menu->addChild('members', array(
            'icon' => 'users',
            'route' => 'dt_user_homepage',
        ))->setExtra('translation_domain', 'menu');
        
        $menu->addChild('profile', array(
            'route' => 'fos_user_profile_show'
        ))->setExtra('translation_domain', 'menu');

        $menu->addChild('demandes', array(
            'route' => 'dt_user_member_history'
        ))->setExtra('translation_domain', 'menu');

        $menu->setExtra('translation_domain', 'menu');
        
        return $menu;
        
    }
    
    public function createLogoutMenu(array $options){
        
        $menu = $this->factory->createItem('root');
        
        $menu->addChild('Connexion', array(
            'route' => 'fos_user_security_login'
        ));
        
        $menu->addChild('Inscription', array(
           'route'  => 'fos_user_registration_register' 
        ));
        
        return $menu;
    }
    
    public function createLoginMenu(array $options){
        
        $menu = $this->factory->createItem('root');
        
        $profil = $menu->addChild('Picture', array(
            'dropdown' => true,
            'caret' => true
        ));
        
        $profil->addChild('Profile');
        $profil->addChild('Mes demandes');
        $profil->addChild('Parametres');
        $profil->addChild('Déconnexion');
        
        return $menu;
    }
}

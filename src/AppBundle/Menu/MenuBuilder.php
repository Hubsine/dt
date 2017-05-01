<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

/**
 * Description of MenuBuilder
 *
 * @author Hubsine
 */
class MenuBuilder {

    public function createMainMenu(FactoryInterface $factory, array $options){
        
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $menu->addChild('Members', array(
            'icon' => 'users',
            'route' => 'dt_user_homepage',
        ));
        $menu->addChild('Profile', array(
            'route' => 'fos_user_profile_show'
        ));

        $menu->addChild('Mes demandes', array(
            'route' => 'dt_user_member_history'
        ));

        return $menu;
        
    }
    
    public function createLogoutMenu(FactoryInterface $factory, array $options){
        
        $menu = $factory->createItem('root');
        
        $menu->addChild('Connexion', array(
            'route' => 'fos_user_security_login'
        ));
        
        $menu->addChild('Inscription', array(
           'route'  => 'fos_user_registration_register' 
        ));
        
        return $menu;
    }
    
    public function createLoginMenu(FactoryInterface $factory, array $options){
        
        $menu = $factory->createItem('root');
        
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

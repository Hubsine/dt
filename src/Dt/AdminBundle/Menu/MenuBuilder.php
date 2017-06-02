<?php

namespace Dt\AdminBundle\Menu;

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
    public $usernameSlug;


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
            $this->usernameSlug = $this->securityTokenStorage->getToken()->getUser()->getSlug();
        }else{
            $this->usernameSlug = 'anon.';
        }
        
    }
    
    public function createSidebarMenu(array $options){
        
        $menu = $this->factory->createItem('admin_sidebar.admin', array(
            'route' => 'dt_admin_homepage',
            'childrenAttributes'    => array(
                'class'             => 'nav nav-sidebar',
            )
        ));
        
        ###
        # Users
        ###
        $users = $menu->addChild('admin_sidebar.users', array(
            'route' => 'dt_admin_users',
            'childrenAttributes'    => array('class'    => 'nav')
        ))
            ->setExtra('translation_domain', 'menu')
            ->setUri('#');
        
        $users->addChild('admin_sidebar.users', array(
            'route' => 'dt_admin_users'
        ))
            ->setExtra('translation_domain', 'menu')
            ->setUri('#');
        
        ###
        # About Users
        ###
        $aboutUsers = $menu->addChild('admin_sidebar.about_users', array(
            'route' => 'dt_admin_about_users',
            'childrenAttributes'    => array('class'    => 'nav')
        ))->setExtra('translation_domain', 'menu');
        
        $aboutUsers->addChild('admin_sidebar.about_users', array(
            'route' => 'dt_admin_about_users'
        ))->setExtra('translation_domain', 'menu');
        
        $aboutUsers->addChild('admin_sidebar.about_users_add', array(
            'route' => 'dt_admin_about_users_add'
        ))->setExtra('translation_domain', 'menu');
        
        return $menu;
    }
}

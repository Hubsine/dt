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
        # About User
        ###
        $aboutUser = $menu->addChild('admin_sidebar.about_user.index', array(
            'route' => 'dt_admin.about_user.index',
            'childrenAttributes'    => array('class'    => 'nav')
        ))->setExtra('translation_domain', 'menu');
        
        $aboutUser->addChild('admin_sidebar.about_user.index', array(
            'route' => 'dt_admin.about_user.index'
        ))->setExtra('translation_domain', 'menu');
        
        $aboutUser->addChild('admin_sidebar.about_user.new', array(
            'route' => 'dt_admin.about_user.new'
        ))->setExtra('translation_domain', 'menu');
        
        ###
        # About User Meta
        ###
        $aboutUserMeta = $menu->addChild('admin_sidebar.about_user_meta.index', array(
            'route' => 'dt_admin.about_user_meta.index',
            'childrenAttributes'    => array('class'    => 'nav')
        ))->setExtra('translation_domain', 'menu');
        
        $aboutUserMeta->addChild('admin_sidebar.about_user.index', array(
            'route' => 'dt_admin.about_user_meta.index'
        ))->setExtra('translation_domain', 'menu');
        
        $aboutUserMeta->addChild('admin_sidebar.about_user_meta.new', array(
            'route' => 'dt_admin.about_user_meta.new'
        ))->setExtra('translation_domain', 'menu');
        
        return $menu;
    }
}

<?php

namespace Dt\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dt\AdminBundle\Form\Type\AboutUsersType;
use Dt\AdminBundle\Entity\AboutUsers;
use Dt\AdminBundle\Doctrine\AboutUsersManager;

class AboutUsersController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtAdminBundle:AboutUsers:index.html.twig', array(
          
        ));
    }
    
    public function addAction(Request $request){
        
        /** @var $aboutUsersManager AboutUsersManager */
        $aboutUsersManager = $this->get('about_users.manager');
        /** @var aboutUsersFormType AboutUsersFormType */
        $aboutUsersFormType = $this->get('dt_admin.form.type.about_users_type');
        
        $view = 'DtAdminBundle:AboutUsers:add.html.twig';
        $aboutUsers = $aboutUsersManager->createEntity(); 
        
        $form = $this->createForm($aboutUsersFormType, $aboutUsers);
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() ){
            
            $aboutUsersManager->updateEntity($aboutUsers);
            
            $message = $this->get('translator')->trans('form.about_users.flash.add_success');
            
            $this->addFlash('success', $message);
            
            $form = $this->createForm($aboutUsersFormType, $aboutUsersManager->createEntity());
        }
        
        return $this->render($view, array(
            'form'  => $form->createView()
        ));
    }

}

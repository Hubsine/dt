<?php

namespace Dt\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dt\AdminBundle\Form\Type\AboutUserType;
use Dt\AdminBundle\Entity\AboutUser;
use Dt\AdminBundle\Doctrine\AboutUserManager;

class AboutUserController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtAdminBundle:AboutUser:index.html.twig', array(
          
        ));
    }
    
    public function addAction(Request $request){
        
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        /** @var aboutUserFormType AboutUserFormType */
        $aboutUserFormType = $this->get('dt_admin.form.type.about_user_type');
        
        $view = 'DtAdminBundle:AboutUser:add.html.twig';
        $aboutUser = $aboutUserManager->createEntity(); 
        
        $form = $this->createForm($aboutUserFormType, $aboutUser);
        
        $form->handleRequest($request);
        
        ###
        # ATTENTION : prendre en compte les cas suivants (créer des constraints)
        # - un tree qui a un "expectedReplyType" text, textCollection, textValCollection ou textara ne peut pas avoir de child
        # - un tree qui a un "expectedReplyType" checkbox ou radio doit obligatoiremnt avoir des enfants 
        # - et ces mêmes enfants ne peuvent avoir d'enfants
        ###
        if( $form->isSubmitted() && $form->isValid() ){
            
            $aboutUserManager->updateEntity($aboutUser);
            
            $message = $this->get('translator')->trans('form.about_user.flash.add_success');
            
            $this->addFlash('success', $message);
            
            $form = $this->createForm($aboutUserFormType, $aboutUserManager->createEntity());
        }
        
        return $this->render($view, array(
            'form'  => $form->createView()
        ));
    }

}

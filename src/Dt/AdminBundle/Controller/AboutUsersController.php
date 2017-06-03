<?php

namespace Dt\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dt\AdminBundle\Form\Type\AboutUsersType;
use Dt\AdminBundle\Entity\AboutUsers;

class AboutUsersController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtAdminBundle:AboutUsers:index.html.twig', array(
          
        ));
    }
    
    public function addAction(Request $request){
        
        $view = 'DtAdminBundle:AboutUsers:add.html.twig';
        $aboutUsersType = new AboutUsersType();
        $aboutUsers = new AboutUsers(); 
        
        $form = $this->createForm($aboutUsersType, $aboutUsers);
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() ){
            
        }
        
        return $this->render($view, array(
            'form'  => $form->createView()
        ));
    }

}

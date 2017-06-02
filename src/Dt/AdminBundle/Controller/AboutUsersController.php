<?php

namespace Dt\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutUsersController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtAdminBundle:AboutUsers:index.html.twig', array(
          
        ));
    }
    
    public function addAction(){
        
        $view = 'DtAdminBundle:AboutUsers:add.html.twig';
        
        return $this->render($view, array(
            
        ));
    }

}

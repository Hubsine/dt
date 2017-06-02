<?php

namespace Dt\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutUserController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtAdminBundle:AboutUser:index.html.twig', array(
          
        ));
    }

}

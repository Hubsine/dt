<?php

namespace Dt\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtUserBundle:Default:index.html.twig');
    }
}

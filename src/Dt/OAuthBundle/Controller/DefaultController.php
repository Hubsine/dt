<?php

namespace Dt\OAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtOAuthBundle:Default:index.html.twig');
    }
}

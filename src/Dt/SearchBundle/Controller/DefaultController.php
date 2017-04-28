<?php

namespace Dt\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtSearchBundle:Default:index.html.twig');
    }
}

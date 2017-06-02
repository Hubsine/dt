<?php

namespace Dt\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('DtAdminBundle::layout.html.twig');
    }
}

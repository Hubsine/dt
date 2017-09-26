<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        $host = $this->getParameter('web_socket_server.host');
//        $port = $this->getParameter('web_socket_server.port');
//        
//        $webSocketServer = $this->get('gos_web_socket.ws.server');
//        $webSocketServer->launch($host, $port, true);
        
        // replace this example code with whatever you need
        return $this->render('AppBundle::layout.html.twig', array(
        ));
    }
}

<?php

namespace Dt\UserBundle\Controller;

use Dt\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * User controller.
 *
 */
class MembersController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('DtUserBundle:User')->findAll();

        return $this->render('DtUserBundle:Members:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {

        return $this->render('DtUserBundle:Members:show.html.twig', array(
            'user' => $user,
        ));
    }
}

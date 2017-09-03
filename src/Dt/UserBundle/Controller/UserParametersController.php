<?php

namespace Dt\UserBundle\Controller;

use Dt\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dt\UserBundle\Form\Type\UserParametersType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * UserParameters controller.
 *
 */
class UserParametersController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        return $this->render('DtUserBundle:Compte:UserParameters/index.html.twig');
    }

    /**
     * Creates a new user entity.
     *
     */
//    public function newAction(Request $request)
//    {
//        $user = new User();
//        $form = $this->createForm('Dt\UserBundle\Form\UserType', $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($user);
//            $em->flush();
//
//            return $this->redirectToRoute('user_parameters_show', array('id' => $user->getId()));
//        }
//
//        return $this->render('user/new.html.twig', array(
//            'user' => $user,
//            'form' => $form->createView(),
//        ));
//    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm(UserParametersType::class, $user);
        
        $editForm->handleRequest($request);

        if ( $editForm->isSubmitted() )
        {
            if ( $editForm->isValid() ) 
            {
                $this->getDoctrine()->getManager()->flush();
            }

        }

    }

    /**
     * Deletes a user entity.
     *
     */
//    public function deleteAction(Request $request, User $user)
//    {
//        $form = $this->createDeleteForm($user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($user);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('user_parameters_index');
//    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
//    private function createDeleteForm(User $user)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('user_parameters_delete', array('id' => $user->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
}

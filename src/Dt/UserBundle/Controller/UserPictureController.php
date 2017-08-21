<?php

namespace Dt\UserBundle\Controller;

use Dt\UserBundle\Entity\UserPicture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Userpicture controller.
 *
 */
class UserPictureController extends Controller
{
    /**
     * Lists all userPicture entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userPictures = $em->getRepository('DtUserBundle:UserPicture')->findAll();

        return $this->render('userpicture/index.html.twig', array(
            'userPictures' => $userPictures,
        ));
    }

    /**
     * Creates a new userPicture entity.
     *
     */
    public function newAction(Request $request)
    {
        $userPicture = new Userpicture();
        $form = $this->createForm('Dt\UserBundle\Form\UserPictureType', $userPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userPicture);
            $em->flush();

            return $this->redirectToRoute('dt_user_user_picture_show', array('id' => $userPicture->getId()));
        }

        return $this->render('userpicture/new.html.twig', array(
            'userPicture' => $userPicture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userPicture entity.
     *
     */
    public function showAction(UserPicture $userPicture)
    {
        $deleteForm = $this->createDeleteForm($userPicture);

        return $this->render('userpicture/show.html.twig', array(
            'userPicture' => $userPicture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userPicture entity.
     *
     */
    public function editAction(Request $request, UserPicture $userPicture)
    {
        $deleteForm = $this->createDeleteForm($userPicture);
        $editForm = $this->createForm('Dt\UserBundle\Form\UserPictureType', $userPicture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dt_user_user_picture_edit', array('id' => $userPicture->getId()));
        }

        return $this->render('userpicture/edit.html.twig', array(
            'userPicture' => $userPicture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userPicture entity.
     *
     */
    public function deleteAction(Request $request, UserPicture $userPicture)
    {
        $form = $this->createDeleteForm($userPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userPicture);
            $em->flush();
        }

        return $this->redirectToRoute('dt_user_user_picture_index');
    }

    /**
     * Creates a form to delete a userPicture entity.
     *
     * @param UserPicture $userPicture The userPicture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserPicture $userPicture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dt_user_user_picture_delete', array('id' => $userPicture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

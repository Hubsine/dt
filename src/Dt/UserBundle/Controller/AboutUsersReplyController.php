<?php

namespace Dt\UserBundle\Controller;

use Dt\UserBundle\Entity\AboutUsersReply;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aboutusersreply controller.
 *
 */
class AboutUsersReplyController extends Controller
{
    /**
     * Lists all aboutUsersReply entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aboutUsersReplies = $em->getRepository('DtUserBundle:AboutUsersReply')->findAll();

        return $this->render('aboutusersreply/index.html.twig', array(
            'aboutUsersReplies' => $aboutUsersReplies,
        ));
    }

    /**
     * Creates a new aboutUsersReply entity.
     *
     */
    public function newAction(Request $request)
    {
        $aboutUsersReply = new Aboutusersreply();
        $form = $this->createForm('Dt\UserBundle\Form\AboutUsersReplyType', $aboutUsersReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aboutUsersReply);
            $em->flush();

            return $this->redirectToRoute('aboutusersreply_show', array('id' => $aboutUsersReply->getId()));
        }

        return $this->render('aboutusersreply/new.html.twig', array(
            'aboutUsersReply' => $aboutUsersReply,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a aboutUsersReply entity.
     *
     */
    public function showAction(AboutUsersReply $aboutUsersReply)
    {
        $deleteForm = $this->createDeleteForm($aboutUsersReply);

        return $this->render('aboutusersreply/show.html.twig', array(
            'aboutUsersReply' => $aboutUsersReply,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing aboutUsersReply entity.
     *
     */
    public function editAction(Request $request, AboutUsersReply $aboutUsersReply)
    {
        $deleteForm = $this->createDeleteForm($aboutUsersReply);
        $editForm = $this->createForm('Dt\UserBundle\Form\AboutUsersReplyType', $aboutUsersReply);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aboutusersreply_edit', array('id' => $aboutUsersReply->getId()));
        }

        return $this->render('aboutusersreply/edit.html.twig', array(
            'aboutUsersReply' => $aboutUsersReply,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aboutUsersReply entity.
     *
     */
    public function deleteAction(Request $request, AboutUsersReply $aboutUsersReply)
    {
        $form = $this->createDeleteForm($aboutUsersReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutUsersReply);
            $em->flush();
        }

        return $this->redirectToRoute('aboutusersreply_index');
    }

    /**
     * Creates a form to delete a aboutUsersReply entity.
     *
     * @param AboutUsersReply $aboutUsersReply The aboutUsersReply entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AboutUsersReply $aboutUsersReply)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aboutusersreply_delete', array('id' => $aboutUsersReply->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

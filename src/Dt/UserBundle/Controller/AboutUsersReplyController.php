<?php

namespace Dt\UserBundle\Controller;

use Dt\UserBundle\Entity\AboutUserReply;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aboutusersreply controller.
 *
 */
class AboutUserReplyController extends Controller
{
    /**
     * Lists all aboutUserReply entities.
     *
     */
    public function indexAction()
    {
        /** @var $aboutUserManager Dt\AdminBundle\Doctrine\AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        /** @var $aboutUserReplyManager Dt\UserBundle\Doctrine\AboutUserReplyManager */
        $aboutUserReplyManager = $this->get('about_user_reply.manager');

        $aboutUser = $aboutUserManager->getRepository()->childrenHierarchy(
            null, false,    
            array(
                array(
                    'decorate' => true,
                    'representationField' => 'slug',
                    'html' => true
                )
        ));
        $aboutUserReplies = $aboutUserReplyManager->getRepository()->findAll();
      

        return $this->render('DtUserBundle:Compte:aboutusersreply/index.html.twig', array(
            'aboutUserReplies' => $aboutUserReplies,
            'aboutUser'    => $aboutUser
        ));
    }

    /**
     * Creates a new aboutUserReply entity.
     *
     */
    public function newAction(Request $request)
    {
        $aboutUserReply = new Aboutusersreply();
        $form = $this->createForm('Dt\UserBundle\Form\AboutUserReplyType', $aboutUserReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aboutUserReply);
            $em->flush();

            return $this->redirectToRoute('aboutusersreply_show', array('id' => $aboutUserReply->getId()));
        }

        return $this->render('aboutusersreply/new.html.twig', array(
            'aboutUserReply' => $aboutUserReply,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a aboutUserReply entity.
     *
     */
    public function showAction(AboutUserReply $aboutUserReply)
    {
        $deleteForm = $this->createDeleteForm($aboutUserReply);

        return $this->render('aboutusersreply/show.html.twig', array(
            'aboutUserReply' => $aboutUserReply,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing aboutUserReply entity.
     *
     */
    public function editAction(Request $request, AboutUserReply $aboutUserReply)
    {
        $deleteForm = $this->createDeleteForm($aboutUserReply);
        $editForm = $this->createForm('Dt\UserBundle\Form\AboutUserReplyType', $aboutUserReply);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aboutusersreply_edit', array('id' => $aboutUserReply->getId()));
        }

        return $this->render('aboutusersreply/edit.html.twig', array(
            'aboutUserReply' => $aboutUserReply,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aboutUserReply entity.
     *
     */
    public function deleteAction(Request $request, AboutUserReply $aboutUserReply)
    {
        $form = $this->createDeleteForm($aboutUserReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutUserReply);
            $em->flush();
        }

        return $this->redirectToRoute('aboutusersreply_index');
    }

    /**
     * Creates a form to delete a aboutUserReply entity.
     *
     * @param AboutUserReply $aboutUserReply The aboutUserReply entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AboutUserReply $aboutUserReply)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aboutusersreply_delete', array('id' => $aboutUserReply->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

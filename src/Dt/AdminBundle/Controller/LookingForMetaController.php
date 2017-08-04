<?php

namespace Dt\AdminBundle\Controller;

use Dt\AdminBundle\Entity\LookingForMeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dt\AdminBundle\Form\Type\LookingForMetaType;

/**
 * LookingforMeta controller.
 *
 */
class LookingForMetaController extends Controller
{
    /**
     * Lists all lookingForMeta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lookingForMetas = $em->getRepository('DtAdminBundle:LookingForMeta')->findAll();

        return $this->render('DtAdminBundle:LookingForMeta:index.html.twig', array(
            'lookingForMetas' => $lookingForMetas,
        ));
    }

    /**
     * Creates a new lookingForMeta entity.
     *
     */
    public function newAction(Request $request)
    {
        $lookingForMeta = new LookingForMeta();
        $form = $this->createForm(LookingForMetaType::class, $lookingForMeta);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lookingForMeta);
            $em->flush();

            return $this->redirectToRoute('dt_admin.looking_for_meta.show', array('id' => $lookingForMeta->getId()));
        }

        return $this->render('DtAdminBundle:LookingForMeta:new.html.twig', array(
            'lookingForMeta' => $lookingForMeta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lookingForMeta entity.
     *
     */
    public function showAction(LookingForMeta $lookingForMeta)
    {
        $deleteForm = $this->createDeleteForm($lookingForMeta);

        return $this->render('DtAdminBundle:LookingForMeta:show.html.twig', array(
            'lookingForMeta' => $lookingForMeta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lookingForMeta entity.
     *
     */
    public function editAction(Request $request, LookingForMeta $lookingForMeta)
    {
        $deleteForm = $this->createDeleteForm($lookingForMeta);
        $editForm = $this->createForm(LookingForMetaType::class, $lookingForMeta);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dt_admin.looking_for_meta.edit', array('id' => $lookingForMeta->getId()));
        }

        return $this->render('DtAdminBundle:LookingForMeta:edit.html.twig', array(
            'lookingForMeta' => $lookingForMeta,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lookingForMeta entity.
     *
     */
    public function deleteAction(Request $request, LookingForMeta $lookingForMeta)
    {
        $form = $this->createDeleteForm($lookingForMeta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lookingForMeta);
            $em->flush();
        }

        return $this->redirectToRoute('dt_admin.looking_for_meta.index');
    }

    /**
     * Creates a form to delete a lookingForMeta entity.
     *
     * @param LookingForMeta $lookingForMeta The lookingForMeta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LookingForMeta $lookingForMeta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dt_admin.looking_for_meta.delete', array('id' => $lookingForMeta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

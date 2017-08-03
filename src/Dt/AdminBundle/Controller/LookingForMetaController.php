<?php

namespace Dt\AdminBundle\Controller;

use Dt\AdminBundle\Entity\LookingForMeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lookingformetum controller.
 *
 */
class LookingForMetaController extends Controller
{
    /**
     * Lists all lookingForMetum entities.
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
     * Creates a new lookingForMetum entity.
     *
     */
    public function newAction(Request $request)
    {
        $lookingForMeta = new LookingForMeta();
        $form = $this->createForm('Dt\AdminBundle\Form\LookingForMetaType', $lookingForMeta);
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
     * Finds and displays a lookingForMetum entity.
     *
     */
    public function showAction(LookingForMeta $lookingForMetum)
    {
        $deleteForm = $this->createDeleteForm($lookingForMetum);

        return $this->render('DtAdminBundle:LookingForMeta:show.html.twig', array(
            'lookingForMetum' => $lookingForMetum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lookingForMetum entity.
     *
     */
    public function editAction(Request $request, LookingForMeta $lookingForMetum)
    {
        $deleteForm = $this->createDeleteForm($lookingForMetum);
        $editForm = $this->createForm('Dt\AdminBundle\Form\LookingForMetaType', $lookingForMetum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dt_admin.looking_for_meta.edit', array('id' => $lookingForMetum->getId()));
        }

        return $this->render('DtAdminBundle:LookingForMeta:edit.html.twig', array(
            'lookingForMetum' => $lookingForMetum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lookingForMetum entity.
     *
     */
    public function deleteAction(Request $request, LookingForMeta $lookingForMetum)
    {
        $form = $this->createDeleteForm($lookingForMetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lookingForMetum);
            $em->flush();
        }

        return $this->redirectToRoute('dt_admin.looking_for_meta.index');
    }

    /**
     * Creates a form to delete a lookingForMetum entity.
     *
     * @param LookingForMeta $lookingForMetum The lookingForMetum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LookingForMeta $lookingForMetum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dt_admin.looking_for_meta.delete', array('id' => $lookingForMetum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

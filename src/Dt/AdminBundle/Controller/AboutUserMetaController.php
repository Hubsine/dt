<?php

namespace Dt\AdminBundle\Controller;

use Dt\AdminBundle\Entity\AboutUserMeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aboutusermetum controller.
 *
 */
class AboutUserMetaController extends Controller
{
    /**
     * Lists all aboutUserMetum entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aboutUserMetas = $em->getRepository('DtAdminBundle:AboutUserMeta')->findAll();

        return $this->render('aboutusermeta/index.html.twig', array(
            'aboutUserMetas' => $aboutUserMetas,
        ));
    }

    /**
     * Creates a new aboutUserMetum entity.
     *
     */
    public function newAction(Request $request)
    {
        $aboutUserMetum = new Aboutusermetum();
        $form = $this->createForm('Dt\AdminBundle\Form\AboutUserMetaType', $aboutUserMetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aboutUserMetum);
            $em->flush();

            return $this->redirectToRoute('aboutusermeta_show', array('id' => $aboutUserMetum->getId()));
        }

        return $this->render('aboutusermeta/new.html.twig', array(
            'aboutUserMetum' => $aboutUserMetum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a aboutUserMetum entity.
     *
     */
    public function showAction(AboutUserMeta $aboutUserMetum)
    {
        $deleteForm = $this->createDeleteForm($aboutUserMetum);

        return $this->render('aboutusermeta/show.html.twig', array(
            'aboutUserMetum' => $aboutUserMetum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing aboutUserMetum entity.
     *
     */
    public function editAction(Request $request, AboutUserMeta $aboutUserMetum)
    {
        $deleteForm = $this->createDeleteForm($aboutUserMetum);
        $editForm = $this->createForm('Dt\AdminBundle\Form\AboutUserMetaType', $aboutUserMetum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aboutusermeta_edit', array('id' => $aboutUserMetum->getId()));
        }

        return $this->render('aboutusermeta/edit.html.twig', array(
            'aboutUserMetum' => $aboutUserMetum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aboutUserMetum entity.
     *
     */
    public function deleteAction(Request $request, AboutUserMeta $aboutUserMetum)
    {
        $form = $this->createDeleteForm($aboutUserMetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutUserMetum);
            $em->flush();
        }

        return $this->redirectToRoute('aboutusermeta_index');
    }

    /**
     * Creates a form to delete a aboutUserMetum entity.
     *
     * @param AboutUserMeta $aboutUserMetum The aboutUserMetum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AboutUserMeta $aboutUserMetum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aboutusermeta_delete', array('id' => $aboutUserMetum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

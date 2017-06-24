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

        return $this->render('DtAdminBundle:AboutUserMeta:index.html.twig', array(
            'aboutUserMetas' => $aboutUserMetas,
        ));
    }

    /**
     * Creates a new aboutUserMetum entity.
     *
     */
    public function newAction(Request $request)
    {
        $aboutUserMeta = new AboutUserMeta();
        $form = $this->createForm('Dt\AdminBundle\Form\Type\AboutUserMetaType', $aboutUserMeta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($aboutUserMeta);
            $em->flush();

            $message = $this->get('translator')->trans('form.about_user_meta.flash.add_success');
            
            $this->addFlash('success', $message);
            
            $form = $this->createForm('Dt\AdminBundle\Form\Type\AboutUserMetaType', new AboutUserMeta());
        }

        return $this->render('DtAdminBundle:AboutUserMeta:new.html.twig', array(
            'aboutUserMeta' => $aboutUserMeta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a aboutUserMeta entity.
     *
     */
    public function showAction(AboutUserMeta $aboutUserMeta)
    {
        $deleteForm = $this->createDeleteForm($aboutUserMeta);

        return $this->render('DtAdminBundle:AboutUserMeta:show.html.twig', array(
            'aboutUserMeta' => $aboutUserMeta,
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
        $editForm = $this->createForm('Dt\AdminBundle\Form\Type\AboutUserMetaType', $aboutUserMetum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dt_admin.about_user_meta.edit', array('id' => $aboutUserMetum->getId()));
        }

        return $this->render('DtAdminBundle:AboutUserMeta:edit.html.twig', array(
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

        return $this->redirectToRoute('dt_admin.about_user_meta.index');
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
            ->setAction($this->generateUrl('dt_admin.about_user_meta.delete', array('id' => $aboutUserMetum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

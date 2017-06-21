<?php

namespace Dt\AdminBundle\Controller;

use Dt\AdminBundle\Entity\AboutUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aboutuser controller.
 *
 */
class AboutUserController extends Controller
{
    /**
     * Lists all aboutUser entities.
     *
     */
    public function indexAction()
    {
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        
        $aboutUser = $aboutUserManager->getRepository()->childrenHierarchy(
            null, false,    
            array(
                'decorate' => true,
//                'rootOpen' => '<ul>',
//                'rootClose' => '</ul>',
//                'childOpen' => '<li>',
//                'childClose' => '</li>',
                'html' => true,
                'nodeDecorator' => function($node) {
                    $url = $this->generateUrl('dt_admin_about_user_edit', array('id' => $node['id']));
                    return '<a href="'.$url.'">'.$node['label'].'</a> ' . $node['expectedReplyType'];
                }
            )
        );

        return $this->render('DtAdminBundle:AboutUser:index.html.twig', array(
            'aboutUser' => $aboutUser,
        ));
    }

    /**
     * Creates a new aboutUser entity.
     *
     */
    public function newAction(Request $request)
    {
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        /** @var aboutUserFormType AboutUserFormType */
        $aboutUserFormType = $this->get('dt_admin.form.type.about_user_type');
        
        $view = 'DtAdminBundle:AboutUser:new.html.twig';
        $aboutUser = $aboutUserManager->createEntity(); 
        
        $form = $this->createForm($aboutUserFormType, $aboutUser);
        
        $form->handleRequest($request);
        
        ###
        # ATTENTION : prendre en compte les cas suivants (créer des constraints)
        # - un tree qui a un "expectedReplyType" text, textCollection, textValCollection ou textara ne peut pas avoir de child
        ###
        if( $form->isSubmitted() && $form->isValid() ){
            
            $aboutUserManager->updateEntity($aboutUser);
            
            $message = $this->get('translator')->trans('form.about_user.flash.add_success');
            
            $this->addFlash('success', $message);
            
            $form = $this->createForm($aboutUserFormType, $aboutUserManager->createEntity());
        }
        
        return $this->render($view, array(
            'form'  => $form->createView()
        ));
        
    }

    /**
     * Finds and displays a aboutUser entity.
     *
     */
    public function showAction(AboutUser $aboutUser)
    {
        $deleteForm = $this->createDeleteForm($aboutUser);

        return $this->render('aboutusers/show.html.twig', array(
            'aboutUser' => $aboutUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing aboutUser entity.
     *
     */
    public function editAction(Request $request, AboutUser $aboutUser)
    {
        
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        /** @var aboutUserFormType AboutUserFormType */
        $aboutUserFormType = $this->get('dt_admin.form.type.about_user_type');
        
        $deleteForm = $this->createDeleteForm($aboutUser);
        $editForm = $this->createForm($aboutUserFormType, $aboutUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $aboutUserManager->updateEntity($aboutUser);

            return $this->redirectToRoute('dt_admin_about_user_edit', array('id' => $aboutUser->getId()));
        }

        return $this->render('DtAdminBundle:AboutUser:edit.html.twig', array(
            'aboutUser' => $aboutUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aboutUser entity.
     *
     */
    public function deleteAction(Request $request, AboutUser $aboutUser)
    {
        $form = $this->createDeleteForm($aboutUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutUser);
            $em->flush();
        }

        return $this->redirectToRoute('dt_admin_about_user_index');
    }

    /**
     * Creates a form to delete a aboutUser entity.
     *
     * @param AboutUser $aboutUser The aboutUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AboutUser $aboutUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dt_admin_about_user_delete', array('id' => $aboutUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

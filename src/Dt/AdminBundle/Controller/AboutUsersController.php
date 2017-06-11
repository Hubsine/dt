<?php

namespace Dt\AdminBundle\Controller;

use Dt\AdminBundle\Entity\AboutUsers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aboutuser controller.
 *
 */
class AboutUsersController extends Controller
{
    /**
     * Lists all aboutUser entities.
     *
     */
    public function indexAction()
    {
        /** @var $aboutUsersManager AboutUsersManager */
        $aboutUsersManager = $this->get('about_users.manager');
        
        $aboutUsers = $aboutUsersManager->getRepository()->childrenHierarchy(
            null, false,    
            array(
                'decorate' => true,
//                'rootOpen' => '<ul>',
//                'rootClose' => '</ul>',
//                'childOpen' => '<li>',
//                'childClose' => '</li>',
                'html' => true,
                'nodeDecorator' => function($node) {
                    $url = $this->generateUrl('dt_admin_about_users_edit', array('id' => $node['id']));
                    return '<a href="'.$url.'">'.$node['label'].'</a>';
                }
            )
        );

        return $this->render('DtAdminBundle:AboutUsers:index.html.twig', array(
            'aboutUsers' => $aboutUsers,
        ));
    }

    /**
     * Creates a new aboutUser entity.
     *
     */
    public function newAction(Request $request)
    {
        /** @var $aboutUsersManager AboutUsersManager */
        $aboutUsersManager = $this->get('about_users.manager');
        /** @var aboutUsersFormType AboutUsersFormType */
        $aboutUsersFormType = $this->get('dt_admin.form.type.about_users_type');
        
        $view = 'DtAdminBundle:AboutUsers:new.html.twig';
        $aboutUsers = $aboutUsersManager->createEntity(); 
        
        $form = $this->createForm($aboutUsersFormType, $aboutUsers);
        
        $form->handleRequest($request);
        
        ###
        # ATTENTION : prendre en compte les cas suivants (créer des constraints)
        # - un tree qui a un "expectedReplyType" text, textCollection, textValCollection ou textara ne peut pas avoir de child
        # - un tree qui a un "expectedReplyType" checkbox ou radio doit obligatoiremnt avoir des enfants 
        # - et ces mêmes enfants ne peuvent avoir d'enfants
        ###
        if( $form->isSubmitted() && $form->isValid() ){
            
            $aboutUsersManager->updateEntity($aboutUsers);
            
            $message = $this->get('translator')->trans('form.about_users.flash.add_success');
            
            $this->addFlash('success', $message);
            
            $form = $this->createForm($aboutUsersFormType, $aboutUsersManager->createEntity());
        }
        
        return $this->render($view, array(
            'form'  => $form->createView()
        ));
        
    }

    /**
     * Finds and displays a aboutUser entity.
     *
     */
    public function showAction(AboutUsers $aboutUser)
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
    public function editAction(Request $request, AboutUsers $aboutUser)
    {
        
        /** @var $aboutUsersManager AboutUsersManager */
        $aboutUsersManager = $this->get('about_users.manager');
        /** @var aboutUsersFormType AboutUsersFormType */
        $aboutUsersFormType = $this->get('dt_admin.form.type.about_users_type');
        
        $deleteForm = $this->createDeleteForm($aboutUser);
        $editForm = $this->createForm($aboutUsersFormType, $aboutUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $aboutUsersManager->updateEntity($aboutUser);

            return $this->redirectToRoute('dt_admin_about_users_edit', array('id' => $aboutUser->getId()));
        }

        return $this->render('DtAdminBundle:AboutUsers:edit.html.twig', array(
            'aboutUser' => $aboutUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aboutUser entity.
     *
     */
    public function deleteAction(Request $request, AboutUsers $aboutUser)
    {
        $form = $this->createDeleteForm($aboutUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aboutUser);
            $em->flush();
        }

        return $this->redirectToRoute('about-users_index');
    }

    /**
     * Creates a form to delete a aboutUser entity.
     *
     * @param AboutUsers $aboutUser The aboutUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AboutUsers $aboutUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dt_admin_about_users_delete', array('id' => $aboutUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

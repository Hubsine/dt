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
    public function indexAction(Request $request)
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
    public function showAction(Request $request, User $user)
    {
        return $this->render('DtUserBundle:Compte:UserParameters/show.html.twig');
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $codeResponse = 200;
        $sectionData = $request->get('sectionData');
        $templateToShow = 'DtUserBundle:Compte:macros.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:UserParameters/edit.html.twig';
        
        $form = $this->createForm(UserParametersType::class, $user);
        
        
        $form->handleRequest($request);

        if ( $form->isSubmitted() )
        {
            if ( $form->isValid() ) 
            {
                $this->getDoctrine()->getManager()->flush();
                
                $message = $this->get('translator')->trans('change_profile.success', array(), 'FOSUserBundle');
                
                $response = new JsonResponse(array(
                    'contentId' => $sectionData['contentId'],
                    'form'  => $this->renderView($templateToShow, array(
                        'message'   => $message,
                        'sectionData'  => $sectionData
                        //'contentId' => $contentId
                    ))
                ), $codeResponse );

                return $response;
            }

            $codeResponse = 400;
            
        }

        $response = new JsonResponse(
            array(
                'contentId' => $sectionData['contentId'],
                'form'  => $this->renderView($templateToEdit, array(
                    'form' => $form->createView(),
                    'sectionData'   => $sectionData
                    //'contentId' => $contentId
                     )
                )
            ), $codeResponse );
        
        return $response;
        
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

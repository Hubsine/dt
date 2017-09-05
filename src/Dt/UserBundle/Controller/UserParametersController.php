<?php

namespace Dt\UserBundle\Controller;

use Dt\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dt\UserBundle\Form\Type\UserParametersType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
        $contentId = $request->get('container');
        $templateToShow = 'DtUserBundle:Compte:UserParameters/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:UserParameters/edit.html.twig';
        
        $form = $this->createForm(UserParametersType::class, $user);
        
        switch ($contentId)
        {
            case 'userParametersPasswordContent':
                $form->add('container', TextType::class, array(
                    'data' => $contentId,
                    'mapped'  => false
                ));
                break;
            
            case 'userParametersEmailContent':
                $form->add('container', TextType::class, array(
                    'data' => $contentId,
                    'mapped'  => false
                ));
                break;
        }
        
        $form->handleRequest($request);

        if ( $form->isSubmitted() )
        {
            if ( $form->isValid() ) 
            {
                $this->getDoctrine()->getManager()->flush();
                
                $message = $this->get('translator')->trans('change_profile.success', array(), 'FOSUserBundle');
                
                $response = new JsonResponse(array(
                    'contentId' => $contentId,
                    'form'  => $this->renderView($templateToShow, array(
                        'message'   => $message
                    ))
                ), $codeResponse );

                return $response;
            }

            $codeResponse = 400;
            
        }

        $response = new JsonResponse(
            array(
                'contentId' => $contentId,
                'form'  => $this->renderView($templateToEdit, array(
                    'form' => $form->createView()
                     ))
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

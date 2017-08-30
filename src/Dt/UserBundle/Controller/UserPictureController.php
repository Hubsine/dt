<?php

namespace Dt\UserBundle\Controller;

use Dt\UserBundle\Entity\UserPicture;
use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Form\Type\UserPictureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gedmo\Uploadable\FileInfo\FileInfoArray;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Userpicture controller.
 *
 * @Route("/membres/{id}/mon-compte/pictures/{pictureId}")
 * 
 */
class UserPictureController extends Controller
{
    /**
     * Lists all userPicture entities.
     *
     */
    public function indexAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $userPictures = $em->getRepository('DtUserBundle:UserPicture')->findAll();
        
        $userPicture = new UserPicture;
        
        $form = $this->createForm(UserPictureType::class, $userPicture);
        
        return $this->render('DtUserBundle:Compte:UserPicture/index.html.twig', array(
            'userPictures' => $userPictures,
            'form'  => $form->createView()
        ));
    }

    /**
     * Creates a new userPicture entity.
     *
     */
    public function newAction(Request $request, User $user)
    {
        $codeResponse = 200;
        $dataResponse = array();
        
        $userPicture = new UserPicture();
        
        $form = $this->createForm(UserPictureType::class, $userPicture);
        
        $form->handleRequest($request);

        if( $form->isSubmitted() ) 
        {  
            $user->addUserPicture($userPicture);
            $errors = $this->get('validator')->validateProperty($user, 'userPictures', array('NewUserPicture'));
            
            if( $form->isValid() && $userPicture->getFile()->isValid() && count($errors) <= 0 )
            {

                $em = $this->getDoctrine()->getManager();
                
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                
                $userManager->updateUser($user, false);
                
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $uploadableManager->markEntityToUpload($userPicture, $userPicture->getFile());

                $em->flush();
                
                $dataResponse['message']    = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
                $dataResponse['item']       = $this->renderView(
                        'DtUserBundle:Compte:UserPicture/item.html.twig', 
                        array('picture' => $userPicture)
                    );
            
                return new JsonResponse($dataResponse, $codeResponse);
                
            }
            
            $validationMessage = '';
            
            if( $errors->count() > 0 )
            {
                foreach ($errors as $key => $error) 
                {
                    $validationMessage = $error->getMessage();
                }
            }
            
            $codeResponse = 400;
            $dataResponse['message'] = (string) $form->getErrors(true) . $validationMessage;
        }

        $response = new JsonResponse($dataResponse, $codeResponse);
        
        return $response;
        
    }

    /**
     * Finds and displays a userPicture entity.
     *
     */
    public function showAction(UserPicture $userPicture)
    {
        $deleteForm = $this->createDeleteForm($userPicture);

        return $this->render('userpicture/show.html.twig', array(
            'userPicture' => $userPicture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userPicture entity.
     *
     */
    public function editAction(Request $request, UserPicture $userPicture)
    {
        $deleteForm = $this->createDeleteForm($userPicture);
        $editForm = $this->createForm('Dt\UserBundle\Form\UserPictureType', $userPicture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dt_user_user_picture_edit', array('id' => $userPicture->getId()));
        }

        return $this->render('userpicture/edit.html.twig', array(
            'userPicture' => $userPicture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * To update user profile picture
     *
     * @Route("/{id}/mon-compte/pictures/{pictureId}/update-user-profile-picture")
     * 
     * @ParamConverter("userPicture", options={"mapping": {"pictureId" = "id"}})
     */
    public function updateUserProfilePictureAction(Request $request, User $user, UserPicture $userPicture)
    {
        $codeResponse = 200;
        $response = array();
        
        if( $request->isXmlHttpRequest() )
        {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            
            $user->setProfilePicture($userPicture);
            
            $userManager->updateUser($user);
            
            $response['message'] = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
        }
        
        return new JsonResponse($response, $codeResponse);
        
        
    }
    
    /**
     * Deletes a userPicture entity.
     *
     * @Route("/{id}/mon-compte/pictures/{pictureId}/delete")
     * 
     * @ParamConverter("userPicture", options={"mapping": {"pictureId" = "id"}})
     */
    public function deleteAction(Request $request, User $user, UserPicture $userPicture)
    {
        $codeResponse = 200;
        $response = array();
        
        $response['count'] = $user->getUserPictures()->count();
        
        if ( $request->isXmlHttpRequest() ) 
        {
            if( $user->getProfilePicture() instanceof UserPicture 
                && $userPicture->getId() === $user->getProfilePicture()->getId() )
            {
                $codeResponse = 400;
                $response['message'] = $this->get('translator')->trans('change_profile.delete_profile_picture',array(), 'FOSUserBundle');
                
                return new JsonResponse($response, $codeResponse);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->remove($userPicture);
            $em->flush();
            
            $response['message'] = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
        }
        
        return new JsonResponse($response, $codeResponse);
    }

    /**
     * Creates a form to delete a userPicture entity.
     *
     * @param UserPicture $userPicture The userPicture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserPicture $userPicture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dt_user_user_picture_delete', array('id' => $userPicture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

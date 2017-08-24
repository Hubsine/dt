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

/**
 * Userpicture controller.
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
        
        $templateToShow = 'DtUserBundle:Compte:AboutUserReply/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:AboutUserReply/edit.html.twig';
        
        $userPicture = new UserPicture();
        
        $form = $this->createForm(UserPictureType::class, $userPicture);
        
        $form->handleRequest($request);

        if( $form->isSubmitted() ) 
        {  
            $dataResponse['file'] = $_FILES;
            if( $form->isValid() && $userPicture->getFile()->isValid() )
            {

                $em = $this->getDoctrine()->getManager();
                $user->addUserPicture($userPicture);
                
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                
                $userManager->updateUser($user, false);
                
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $uploadableManager->markEntityToUpload($userPicture, $userPicture->getFile());

                $em->flush();
                
                $dataResponse['errorCode'] = $userPicture->getFile()->getError();
                $dataResponse['uploadIsvalid'] = $userPicture->getFile()->isValid();
                $dataResponse['uploadedmsgError'] = $userPicture->getFile()->getErrorMessage();
                $dataResponse['message']    = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
            
                return new JsonResponse($dataResponse, $codeResponse);
                
            }
            
            $codeResponse = 400;
            $dataResponse['message'] = (string) $form->getErrors();
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
     * Deletes a userPicture entity.
     *
     */
    public function deleteAction(Request $request, UserPicture $userPicture)
    {
        $form = $this->createDeleteForm($userPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userPicture);
            $em->flush();
        }

        return $this->redirectToRoute('dt_user_user_picture_index');
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

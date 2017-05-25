<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dt\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Dt\UserBundle\Form\Type\MoiFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use Dt\UserBundle\Entity\User;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Controller managing the user profile.
 * 
 * @author Christophe Coevoet <stof@notk.org>
 */
class CompteController extends Controller
{
    /**
     * Show the user.
     * 
     * - check permisssion pour OWNER
     */
    public function viewAction(User $user)
    {
        #$aclManager = $this->get('oneup_acl.manager');
        #$aclManager->addObjectPermission($user, MaskBuilder::MASK_OWNER, $identity = null);
        
        return $this->render('DtUserBundle:Compte:layout.html.twig');
    }

    /**
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function editMoiAction(Request $request, User $user)
    {
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        
        $user = $this->getUser();
        
        $form = $this->createForm(MoiFormType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            
            $userManager->updateUser($user);
            
            $response = new JsonResponse(array(
                'contentId' => 'moiContent',
                'form'  => $this->renderView('DtUserBundle:Compte:tab_profile_moi.html.twig', array(
                    'form' => $form->createView(),
                    'message'   => $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle')
                     ))
            ), 200);
            
            return $response;
        }else{
            
            if($request->getMethod() === 'POST' and !$form->isValid()){
                $response = new JsonResponse(array(
                    'contentId' => 'moiContent',
                    'form'  => $this->renderView('DtUserBundle:Compte:tab_profile_moi.html.twig', array(
                        'form' => $form->createView(),
                         ))
                ), 400);
            
                return $response;
            }
        }
        
        return $this->render('DtUserBundle:Compte:tab_profile_moi.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

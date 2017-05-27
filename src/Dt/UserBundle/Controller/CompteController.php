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
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Util\ClassUtils;

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
        #$aclManager->setObjectPermission($user, MaskBuilder::MASK_OWNER, UserSecurityIdentity::fromAccount($user));
        
        return $this->render('DtUserBundle:Compte:layout.html.twig');
    }

    public function showMoiAction(Request $request, User $user){
        
        return $this->render('DtUserBundle:Compte:Moi/show.html.twig');
    }
    
    public function showReseauxSociauxAction(Request $request, User $user){
        return $this->render('DtUserBundle:Compte:ReseauxSociaux/show.html.twig');
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
        $currentUser = clone $user; 
        
        $user = $this->getUser();
        
        $form = $this->createForm(MoiFormType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            if($form->isValid()){
                
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');

                $user->setSlug($form->getData()->getUsername());
                $userManager->updateUser($user);

                $message = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
                $newCompteUrl = null;

                if($currentUser->getUsername() !== $user->getUsername()){

                    $newCompteUrl = $this->generateUrl('dt_user_members_mon_compte', array('slug'=> $user->getSlug()));


                    $aclManager = $this->get('oneup_acl.manager');
                    $aclManager->addObjectPermission($user, MaskBuilder::MASK_OWNER, UserSecurityIdentity::fromAccount($user));

                    /** @var \Oneup\AclBundle\Security\Authorization\Acl\AclProvider */
                    $securityAclProvider = $this->get('security.acl.provider');
                    $securityAclProvider->deleteSecurityIdentity( UserSecurityIdentity::fromAccount($currentUser) );

                }

                $response = new JsonResponse(array(
                    'contentId' => 'moiContent',
                    'newCompteUrl'  => $newCompteUrl,
                    'data'  => $currentUser->getUsername() . '/'. $user->getUsername(), // Supprimer cette liste test
                    'form'  => $this->renderView('DtUserBundle:Compte:Moi/show.html.twig', array(
                        'message'   => $message
                         ))
                ), 200);

                return $response;
                
            }else{
                
                $response = new JsonResponse(array(
                    'contentId' => 'moiContent',
                    'form'  => $this->renderView('DtUserBundle:Compte:Moi/edit.html.twig', array(
                        'form' => $form->createView(),
                         ))
                ), 400);

                return $response;
            }
        }
        
        $response = new JsonResponse(
            array(
                'contentId' => 'moiContent',
                'form'  => $this->renderView('DtUserBundle:Compte:Moi/edit.html.twig', array(
                    'form' => $form->createView(),
                     ))
            ), 200);
        
        return $response;
    }
}

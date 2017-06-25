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
use Dt\UserBundle\Form\Type\ReseauxSociauxFormType;
use Dt\UserBundle\Form\Type\AboutUserReplyType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Entity\AboutUserReply;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

    public function showMoiAction(Request $request, User $user)
    {
        
        return $this->render('DtUserBundle:Compte:Moi/show.html.twig');
    }
    
    public function showReseauxSociauxAction(Request $request, User $user)
    {
        return $this->render('DtUserBundle:Compte:ReseauxSociaux/show.html.twig');
    }
    
    public function showQuiSuisJeAction(Request $request, User $user)
    {
        return $this->render('DtUserBundle:Compte:QuiSuisJe/show.html.twig');
    }
    
    public function showAboutUserReplyAction(Request $request, User $user){
        
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');

        $ab = $aboutUserManager->getRepository()->childrenHierarchy(null, false, array('decorate'  => false));
        $form = $this->getAboutUserReplyForm($ab);
        
        $aboutUser = $aboutUserManager->getUsersReplyView(null, false, $this->getTreeOptions());

        return $this->render('DtUserBundle:Compte:AboutUserReply/show.html.twig', array(
            'aboutUser'    => $aboutUser,
            'ab'    => $ab,
            'form'  => $form
        ));
    }

    public function editAboutUserReplyAction(Request $request, User $user)
    {
        
        /** aboutUserReplyManager \Dt\UserBundle\Doctrine\AboutUserReplyManager */
        $aboutUserReplyManager = $this->get('about_user_reply.manager');
        
        $codeResponse = 200;
        $contentId = 'aboutUserReplyContent';
        $templateToShow = 'DtUserBundle:Compte:AboutUserReply/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:AboutUserReply/edit.html.twig';
        
        $aboutUserReply = $aboutUserReplyManager->createEntity();
        $form = $this->createForm(AboutUserReplyType::class, $aboutUserReply);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            if($form->isValid()){
                
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                
                $userManager->updateUser($user);
                
                $message = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
                
                $response = new JsonResponse(array(
                    'contentId' => $contentId,
                    'form'  => $this->renderView($templateToShow, array(
                        'message'   => $message
                         ))
                ), $codeResponse );

                return $response;
                
            }else{
                $codeResponse = 400;
            }
        }
        
        $response = new JsonResponse(
            array(
                'contentId' => $contentId,
                'form'  => $this->renderView($templateToEdit, array(
                    'form' => $form->createView(),
                     ))
            ), $codeResponse );
        
        return $response;
        
    }
    
    public function editQuiSuisJeAction(Request $request, User $user){
        
        $codeResponse = 200;
        $contentId = 'quiSuisJeContent';
        $templateToShow = 'DtUserBundle:Compte:QuiSuisJe/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:QuiSuisJe/edit.html.twig';
        
        $user = $this->getUser();
        $form = $this->createForm(ReseauxSociauxFormType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            if($form->isValid()){
                
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                
                $userManager->updateUser($user);
                
                $message = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
                
                $response = new JsonResponse(array(
                    'contentId' => $contentId,
                    'form'  => $this->renderView($templateToShow, array(
                        'message'   => $message
                         ))
                ), $codeResponse );

                return $response;
                
            }else{
                $codeResponse = 400;
            }
        }
        
        $response = new JsonResponse(
            array(
                'contentId' => $contentId,
                'form'  => $this->renderView($templateToEdit, array(
                    'form' => $form->createView(),
                     ))
            ), $codeResponse );
        
        return $response;
        
    }
    
    public function editReseauxSociauxAction(Request $request, User $user){
        
        $codeResponse = 200;
        $contentId = 'reseauxSociauxContent';
        $templateToShow = 'DtUserBundle:Compte:ReseauxSociaux/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:ReseauxSociaux/edit.html.twig';
        
        $user = $this->getUser();
        $form = $this->createForm(ReseauxSociauxFormType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            if($form->isValid()){
                
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                
                $userManager->updateUser($user);
                
                $message = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
                
                $response = new JsonResponse(array(
                    'contentId' => $contentId,
                    'form'  => $this->renderView($templateToShow, array(
                        'message'   => $message
                         ))
                ), $codeResponse );

                return $response;
                
            }else{
                $codeResponse = 400;
            }
        }
        
        $response = new JsonResponse(
            array(
                'contentId' => $contentId,
                'form'  => $this->renderView($templateToEdit, array(
                    'form' => $form->createView(),
                     ))
            ), $codeResponse );
        
        return $response;
        
    }
    
    /**
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function editMoiAction(Request $request, User $user)
    {
        
        $codeResponse = 400;
        
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $currentUser = clone $user; 
        
        $user = $this->getUser();
        
        $form = $this->createForm(MoiFormType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            if($form->isValid()){

                $codeResponse = 200;
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
                ), $codeResponse);

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
    
    public function getTreeOptions(){
        
        $aboutUserReplyManager = $this->get('about_user_reply.manager');
        $controller = $this;
        #$replies = $aboutUserReplyManager->getUserReply($this->getUser());
        
        $treeOptions = array(
            'rootOpen' => function($tree){
            
                $node = $tree[0];
                
                $class = '';
                if($node['lvl'] === 0){
                    $class .= "list-group mainNode";
                }
                
                if($node['lvl'] > 0 )
                {
                    $class .= 'list-unstyled list-inline';
                }
                
                return '<ul class="'.$class.'">';
            },
            'rootClose' => '</ul>',
            'childOpen' => function($node){
                
                $class = '';

                if($node['lvl'] === 0){
                    $class .= 'list-group-item ';
                }

                return '<li class="'.$class.'">';
            },
            'childClose' => function($tree){
//                if($tree['lvl'] == 0){
//                    return '</h3>';
//                }
                return '</li>';
            },
            'nodeDecorator' => function($node) use (&$controller, $aboutUserReplyManager) {

                $html = '';

                if($node['lvl'] === 0){
                    return '<h4 class="text-center list-group-item-heading">' . $node['label'] . '</h4>';
                }

                return '<span class="">' . $node['label'] . '</span>' . $html;
            }
        );
         
         return $treeOptions;
    }
    
    public function getAboutUserReplyForm(array $tree){
        
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        $aboutUserReplyManager = $this->get('about_user_reply.manager');
        
        $aboutUser = $aboutUserManager->getRepository()->getChildren();
        #$replies = $aboutUserReplyManager->getUserReply($this->getUser());
        $form = $this->createFormBuilder();
        
        function iterator($tree, $form, $aboutUser){
            
            foreach ($tree as $key => $node) 
            {
                //echo $node['label'];
                
                switch ($node['expectedReplyType'])
                {
                    case 'radio':
                        if(count($node['__children']) > 0){
                            $choices = array();
                            foreach($aboutUser as $aboutUserKey => $aboutUser) {
                                
                                if($aboutUser->getId() == $node['id']){
                                    echo $aboutUser->getParent()->getLabel();
                                    $choices[] = $aboutUser;
                                }
                            }
                            //echo count($choices);
                            foreach ($node['__children'] as $childrenKey => $children) {
                                $choices[]  = (object) $children;
                            }

                            //var_dump($choices);
                            //var_dump($node['__children']);
                            $form->add('aboutUser'.$node['id'], EntityType::class, array(
                                'choices'   => array($aboutUser[8]),
                                'multiple'  => false,
                                'expanded'  => true,
                                'choices_as_values' => true,
                                'class' => 'DtAdminBundle:AboutUser',
                                //'label_attr'    => array('class'    => 'hidden'),
                                'choice_label' => function ($value, $key, $index) {

                                    return $value->getLabel();

                                },
                            ));
                        }
                        break;
                }
            
                if (count($node['__children']) > 0) 
                {
                    iterator($node['__children'], $form, $aboutUser);
                }
            }
        }
        
        iterator($tree, $form, $aboutUser);
        
        return $form->getForm()->createView();
    }
}

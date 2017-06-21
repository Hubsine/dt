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
use Dt\UserBundle\Form\Type\AboutUsersReplyType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Entity\AboutUsersReply;
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
    
    public function showAboutUsersReplyAction(Request $request, User $user){
        
        /** @var $aboutUsersManager AboutUsersManager */
        $aboutUsersManager = $this->get('about_users.manager');

        $ab = $aboutUsersManager->getRepository()->childrenHierarchy(null, false, array('decorate'  => false));
        $form = $this->getAboutUsersReplyForm($ab);
        
        $aboutUsers = $aboutUsersManager->getUsersReplyView(null, false, $this->getTreeOptions());

        return $this->render('DtUserBundle:Compte:AboutUsersReply/show.html.twig', array(
            'aboutUsers'    => $aboutUsers,
            'ab'    => $ab,
            'form'  => $form
        ));
    }

    public function editAboutUsersReplyAction(Request $request, User $user)
    {
        
        /** aboutUsersReplyManager \Dt\UserBundle\Doctrine\AboutUsersReplyManager */
        $aboutUsersReplyManager = $this->get('about_users_reply.manager');
        
        $codeResponse = 200;
        $contentId = 'aboutUsersReplyContent';
        $templateToShow = 'DtUserBundle:Compte:AboutUsersReply/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:AboutUsersReply/edit.html.twig';
        
        $aboutUsersReply = $aboutUsersReplyManager->createEntity();
        $form = $this->createForm(AboutUsersReplyType::class, $aboutUsersReply);
        
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
        
        $aboutUsersReplyManager = $this->get('about_users_reply.manager');
        $controller = $this;
        #$replies = $aboutUsersReplyManager->getUserReply($this->getUser());
        
        $treeOptions = array(
            'rootOpen' => function($tree){
            
                $node = $tree[0];
                
                // On affiche pas les derniers elements dont le parent a un expectedReplyType autre que text, textarea
                if(empty($node['__children']) && 
                        !in_array($node['expectedReplyType'], array('text', 'textarea', 'textCollection', 'textValCollection'))){
                    return '';
                }
                
                $class = '';
                if($node['lvl'] === 0){
                    $class .= "list-unstyled list-group";
                }
                
                return '<ul class="'.$class.'">';
            },
            'rootClose' => '</ul>',
            'childOpen' => function($node){
                
                // On affiche pas les derniers elements dont le parent a un expectedReplyType autre que text, textarea
                if(empty($node['__children']) && 
                        !in_array($node['expectedReplyType'], array('text', 'textarea', 'textCollection', 'textValCollection'))){
                    return '';
                }
                
                $class = '';
                if(empty($node['__children'])){
                    $class .= 'nodeLastChild ';
                }

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
            'nodeDecorator' => function($node) use (&$controller, $aboutUsersReplyManager) {

                $html = '';
                
                // On affiche pas les derniers elements dont le parent a un expectedReplyType autre que text, textarea
                if(empty($node['__children']) && 
                        !in_array($node['expectedReplyType'], array('text', 'textarea', 'textCollection', 'textValCollection'))){
                    return '';
                }
                
                #if(empty($node['__children'])){
                    
                    switch ($node['expectedReplyType']){

                        case '':
                            
                            break;
                        
                        case 'textarea':

                            break;

                        case 'radio':
                            $start = '<ul>';
                            $end = '</ul>';
                            $lis = '';
                            foreach ($node['__children'] as $key => $children) {
                                $lis .= '<li class="radioReply">'.$children['label'].'</li>';
                            }
                            $html = $start . $lis . $end;
                            break;
                        
                        case 'checkbox':
                            break;
                    }
                #}

                if($node['lvl'] === 0){
                    return '<h4 class="text-center list-group-item-heading">' . $node['label'] . '</h4>';
                }

                return '<span class="">' . $node['label'] . '</span>' . $html;
            }
        );
         
         return $treeOptions;
    }
    
    public function getAboutUsersReplyForm(array $tree){
        
        /** @var $aboutUsersManager AboutUsersManager */
        $aboutUsersManager = $this->get('about_users.manager');
        $aboutUsersReplyManager = $this->get('about_users_reply.manager');
        
        $aboutUsers = $aboutUsersManager->getRepository()->getChildren();
        #$replies = $aboutUsersReplyManager->getUserReply($this->getUser());
        $form = $this->createFormBuilder();
        
        function iterator($tree, $form, $aboutUsers){
            
            foreach ($tree as $key => $node) 
            {
                //echo $node['label'];
                
                switch ($node['expectedReplyType'])
                {
                    case 'radio':
                        if(count($node['__children']) > 0){
                            $choices = array();
                            foreach($aboutUsers as $aboutUsersKey => $aboutUser) {
                                
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
                            $form->add('aboutUsers'.$node['id'], EntityType::class, array(
                                'choices'   => array($aboutUsers[8]),
                                'multiple'  => false,
                                'expanded'  => true,
                                'choices_as_values' => true,
                                'class' => 'DtAdminBundle:AboutUsers',
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
                    iterator($node['__children'], $form, $aboutUsers);
                }
            }
        }
        
        iterator($tree, $form, $aboutUsers);
        
        return $form->getForm()->createView();
    }
}

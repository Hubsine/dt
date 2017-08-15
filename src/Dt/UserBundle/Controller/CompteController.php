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
use Dt\UserBundle\Form\Type\LookingForType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dt\UserBundle\Entity\User;
use Dt\UserBundle\Entity\AboutUserReply;
use Dt\UserBundle\Entity\LookingFor;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Doctrine\ORM\EntityRepository;
use Dt\AdminBundle\Entity\AboutUser;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Valid;

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
    
    public function showAboutUserReplyAction(Request $request, User $user){
        
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        
        $aboutUser = $aboutUserManager->getUsersReplyView(null, false, $this->getTreeOptions());

        return $this->render('DtUserBundle:Compte:AboutUserReply/show.html.twig', array(
            'aboutUser'    => $aboutUser
        ));
    }
    
    public function showLookingForAction(Request $request, User $user)
    {
        /** lookingForManager \Dt\UserBundle\Doctrine\LookingForManager */
        $lookingForManager = $this->get('looking_for.manager');
        
        $lookingFor = $lookingForManager
                ->getRepository()
                ->findByUser($user);
        
        return $this->render(
            'DtUserBundle:Compte:LookingFor/show.html.twig',array(
                'lookingFor'    => $lookingFor
            )
        );
    }

    public function editAboutUserReplyAction(Request $request, User $user)
    {
        
        /** aboutUserReplyManager \Dt\UserBundle\Doctrine\AboutUserReplyManager */
        $aboutUserReplyManager = $this->get('about_user_reply.manager');
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        
        $codeResponse = 200;
        $contentId = 'aboutUserReplyContent';
        $templateToShow = 'DtUserBundle:Compte:AboutUserReply/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:AboutUserReply/edit.html.twig';
        
        $aboutUsers = $aboutUserManager->getRepository()->childrenHierarchy(null, false, array('decorate'  => false));
        $form = $this->getAboutUserReplyForm($aboutUsers);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            if($form->isValid()){
                
                /** @var $userManager UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                
                //$userManager->updateUser($user);
                
                foreach ($form->getData() as $key => $aboutUserReply) {
                    $aboutUserReplyManager->updateEntity($aboutUserReply, false);
                }
                $aboutUserReplyManager->flush();
                
                $message = $this->get('translator')->trans('change_profile.success',array(), 'FOSUserBundle');
                
                $response = new JsonResponse(array(
                    'contentId' => $contentId,
                    'form'  => $this->renderView($templateToShow, array(
                        'aboutUser' => $aboutUserManager->getUsersReplyView(null, false, $this->getTreeOptions()),
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
                    'aboutUsers'    => $aboutUsers
                     ))
            ), $codeResponse );
        
        return $response;
        
    }
    
    public function editLookingForAction(Request $request, User $user){
        
        $codeResponse = 200;
        $contentId = 'lookingForContent';
        $templateToShow = 'DtUserBundle:Compte:LookingFor/show.html.twig';
        $templateToEdit = 'DtUserBundle:Compte:LookingFor/edit.html.twig';
        
        $lookingFor = new LookingFor();
        $form = $this->createForm(LookingForType::class, $lookingFor);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            if($form->isValid()){
                
                /** @var $userManager UserManagerInterface */
                //$userManager = $this->get('fos_user.user_manager');
                
                //$userManager->updateUser($user);
                
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
        $userResponses = $aboutUserReplyManager->getUserReply($this->getUser());
        $aboutUserReplys = array();
        
        foreach ($userResponses as $key => $aboutUserReply) {
            $aboutUserReplys[$aboutUserReply->getAboutUser()->getId()] = $aboutUserReply;
        }
        
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
            'nodeDecorator' => function($node) use (&$controller, $aboutUserReplyManager, $aboutUserReplys) {

                $html = '';
                $itemOpen = '<div class="item label label-default">';
                $itemClose = '</div>';
                
                if( array_key_exists($node['id'], $aboutUserReplys) )
                {
                    $userResponse = $aboutUserReplys[$node['id']];
                    $expected = $userResponse->getAboutUser()->getExpectedReplyType();
                    
                    switch ($expected)
                    {
                        case 'checkbox':
                            $checkboxResponse = $userResponse->getResponseCheckbox()->getValues();
                            foreach ($checkboxResponse as $key => $aboutUserMeta) {
                                $html .= $itemOpen . $aboutUserMeta->getLabel() . $itemClose;
                            }
                            break;
                        
                        case 'radio':
                            $html .= ( !empty( $userResponse->getResponseRadio() ) ) ? 
                                $itemOpen . $userResponse->getResponseRadio()->getLabel() . $itemClose : '';
                            break;
                        
                        case 'text':
                            $html .= $itemOpen . $userResponse->getResponseText() . $itemClose;
                            break;
                        
                        case 'textCollection':
                            $textCollectionResponse = $userResponse->getResponseTextCollection();
                            foreach ($textCollectionResponse as $key => $value) {
                                $html .= $itemOpen . $value . $itemClose;
                            }
                            //$html .= implode(',', $userResponse->getResponseTextCollection());
                            break;
                        
                        case 'textValCollection':
                            $textValCollectionResponse = $userResponse->getResponseTextValCollection();
                            foreach ($textValCollectionResponse as $key => $value) {
                                $html .= $itemOpen . $value . $itemClose;
                            }
                            //$html .= implode(',', $userResponse->getResponseTextValCollection());
                            break;
                        
                        case 'textarea':
                            $html .= $itemOpen . $userResponse->getResponseTextarea() . $itemClose;
                            break;
                    }
                }
                
                if($node['lvl'] === 0){
                    return '<h4 class="text-center list-group-item-heading">' . $node['label'] . '</h4>' . $html;
                }

                return '<div class="">' . $node['label'] . '</div>' . $html;
            }
        );
         
         return $treeOptions;
    }
    
    public function getAboutUserReplyForm(array $tree){
        
        /** @var $aboutUserManager AboutUserManager */
        $aboutUserManager = $this->get('about_user.manager');
        $aboutUserReplyManager = $this->get('about_user_reply.manager');
        $user = $this->getUser();
        
        $aboutUsers = array();
        $aboutUserReplys = array();
        
        $userResponses = $aboutUserReplyManager->getUserReply($this->getUser());
        
        foreach ($userResponses as $key => $aboutUserReply) {
            $aboutUserReplys[$aboutUserReply->getAboutUser()->getId()] = $aboutUserReply;
        }
        
        $nodes = $aboutUserManager
            ->getRepository()->createQueryBuilder('node')
            ->orderBy('node.root, node.lft', 'ASC')
            ->getQuery()
            ->getResult();
        
        foreach ($nodes as $key => $node) 
        {
            $aboutUsers[$node->getId()] = $node;
        }
        
        $builder = $this->createFormBuilder(null, array(
                'validation_groups'=> array('AboutUserReply'),
                'constraints' => array(new Valid()),
            )
        );
        
        function iterator($tree, $builder, $aboutUsers, $aboutUserReplys, $user){
            
            foreach ($tree as $key => $node) 
            {
                
                $aboutUser = $aboutUsers[$node['id']];
                $expectedReplyType = $node['expectedReplyType'];
                
                if ( in_array( $expectedReplyType, AboutUser::getExpectedReplyTypeArray() ) )
                {
                    $aboutUserReply = new AboutUserReply();
                    
                    $aboutUserReply->setAboutUser($aboutUser);
                    $aboutUserReply->setUser($user);
                    
                    
                    // Determine la réponse courante (recuperer dans la bdd)
                    if(array_key_exists($aboutUser->getId(), $aboutUserReplys))
                    {
                        $aboutUserReply = $aboutUserReplys[$aboutUser->getId()];
                    }
                    
                    $builder->add('aboutUserReply'.$node['id'], AboutUserReplyType::class, array(
                       'node'  => $node,
                       'aboutUser' => $aboutUser, 
                       //'aboutUserReplys' => $aboutUserReplys, 
                       'label' => false,
                       //'error_bubbling'   => false,
                       'validation_groups' => array($expectedReplyType),
                       'constraints' => array(new Valid()),
                        'data'  => $aboutUserReply
                        )
                         
                    );
                    
                }
            
                if (count($node['__children']) > 0) 
                {
                    iterator($node['__children'], $builder, $aboutUsers, $aboutUserReplys, $user);
                }
            }
        }
        
        iterator($tree, $builder, $aboutUsers, $aboutUserReplys, $user);
        
        return $builder->getForm();
    }
}

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

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Controller\ChangePasswordController as BaseController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller managing the password change.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ChangePasswordController extends BaseController
{
    /**
     * Change user password.
     *
     * - ne retourn que du json
     * - check permisson pour editer\OWNER
     * 
     * @param Request $request
     *
     * @return Response
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

//            if (null === $response = $event->getResponse()) {
//                $url = $this->generateUrl('fos_user_profile_show');
//                $response = new RedirectResponse($url);
//            }
            // Utiliser plutot un evenement ?
            $response = new JsonResponse(array(
                'contentId' => 'passwordContent',
                'form'  => $this->renderView('@FOSUser/ChangePassword/change_password.html.twig', array(
                    'form' => $form->createView(),
                    'message'   => $this->get('translator')->trans('change_password.flash.success',array(), 'FOSUserBundle')
                     ))
            ), 200);

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            
            return $response;
        }else{
            
            if($request->getMethod() === 'POST' and !$form->isValid()){
            $response = new JsonResponse(array(
                'contentId' => 'passwordContent',
                'form'  => $this->renderView('@FOSUser/ChangePassword/change_password.html.twig', array(
                    'form' => $form->createView(),
                     ))
            ), 400);
            
            return $response;
            }
        }

        
        return $this->render('@FOSUser/ChangePassword/change_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

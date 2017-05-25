<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dt\UserBundle;

/**
 * Contains all events thrown in the DtUserBundle.
 * 
 * @author Hubsine
 */
final class DtUserEvents {
    
    /**
     * The HYDRATE_USER_FROM event occurs when the OAuthResponse is returned by social connected or registration
     * 
     * Cette evenement permet d'hydrater le user selon le resources owner
     * 
     * @Event("Dt\UserBundle\Event\OAuthUserEvent")
     */
    const HYDRATE_USER_FROM = 'dt_user.hydrate.fos_user.from_resource_owners';
    
    const USER_LOGIN_INITIALIZE = 'dt_user.login.initialize';
    
    const OAUTH_REGISTRATION_SUCCESS = 'dt_user.oauth_registration.success';

}

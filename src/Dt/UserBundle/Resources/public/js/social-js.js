function googleSignInOnSuccess(googleUser) {

//    var profile = googleUser.getBasicProfile();
//    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
//    console.log('Name: ' + profile.getName());
//    console.log('Image URL: ' + profile.getImageUrl());
//    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
    
    document.location = Routing.generate('hwi_oauth_service_redirect', { service: "google" }, true);
    
}

function googleSignInOnError(error){
    console.log(error);
}

function attachSignin(element) {
    auth2.attachClickHandler(element, {}, googleSignInOnSuccess, googleSignInOnError);
}
  
gapi.load('auth2', function(){
    auth2 = gapi.auth2.init({
        client_id: '392314135321-b2uun47jopmnvp16np3llejerqqvvtp2.apps.googleusercontent.com',
        ux_mode: 'popup', // Or redirect
        //redirect_uri: Routing.generate('hwi_oauth_service_redirect', { service: "google" }, true),
        cookiepolicy: 'single_host_origin'
        //include_granted_scopes: true
    });
    attachSignin(document.getElementById('google-login-btn'));
});
    
   





function FbLogin(){
    
    FB.getLoginStatus(function(response) {
        console.log(response);
        if (response.status === 'connected') {
            // connected
            alert('Already connected, redirect to login page to create token.');
            document.location = Routing.generate('hwi_oauth_service_redirect', { service: "facebook" }, true);
        } else {
            // not_authorized
            FB.login(function(response) {
                if (response.authResponse) {
                    document.location = Routing.generate('hwi_oauth_service_redirect', { service: "facebook" }, true);
                } else {
                    //alert('Cancelled.');
                }
            }, {scope: 'email'});
        }
    });
}

function statusChangeCallback(response) {
    
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
}

function checkLoginState() {
    
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
    
}

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
}
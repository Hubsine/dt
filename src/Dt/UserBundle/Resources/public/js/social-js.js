

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
    
//    FB.login(function(response) {
//        if (response.status === 'connected') {
//            alert('Already connected, redirect to login page to create token.');
//            document.location = Routing.generate('hwi_oauth_service_redirect', { service: "facebook" }, true);
//        } else {
//            // The person is not logged into this app or we are unable to tell. 
//            FB.login(function(response){
//               if (response.authResponse) {
//                   document.location = Routing.generate('hwi_oauth_service_redirect', { service: "facebook" }, true);
//               } else {
//                   alert('Cancelled.');
//               } 
//            }, {scope: 'public_profile,email,user_about_me,user_birthday,user_location'});
//        }
//    }, {scope: 'public_profile,email,user_about_me,user_birthday,user_location'});
    
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
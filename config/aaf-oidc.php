<?php
// config for Marcorombach/LaravelAafOIDC
return [
    'provider_url' => '', //URL of the auth endpoint at the provider
    'client_secret' => '', //Client secret
    'client_id' => '', //Client ID
    'post-login' => '', //Route to redirect to after login - if not set you will be redirected to the base URL
    'error-route' => '', //Route to redirect to on login error
];

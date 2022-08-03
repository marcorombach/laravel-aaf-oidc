<?php
// config for Marcorombach/LaravelAafOIDC
return [
    'provider_url' => '', //issuer URL of the auth provider -> https://<aaf-domainname>/osp/a/TOP/auth/oauth2
    'client_secret' => '', //Client secret
    'client_id' => '', //Client ID
    'post-login-route' => '', //Route to redirect to after login - if not set you will be redirected to the base URL
    'error-route' => '', //Route to redirect to on login error - redirects with $error variable set
];

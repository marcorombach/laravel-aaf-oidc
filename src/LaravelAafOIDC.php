<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Routing\Controller;
use Jumbojett\OpenIDConnectClient;

class LaravelAafOIDC extends Controller
{
    function authenticate(){

        $oidc = new OpenIDConnectClient(config('aaf-oidc.provider_url'),config('aaf-oidc.client_id'),config('aaf-oidc.client_secret'));
        $oidc->setRedirectURL(url('/oidc-callback'));
        $oidc->authenticate();

        $access = true;

        //TODO: Return Authenticable (e.g. User-Object)
        if($access){
            return true;
        }else{
            return false;
        }
    }
}

<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use Jumbojett\OpenIDConnectClient;

class LaravelAafOIDC extends Controller
{
    private $user;

    function authenticate(){

        $oidc = new OpenIDConnectClient(config('aaf-oidc.provider_url'),config('aaf-oidc.client_id'),config('aaf-oidc.client_secret'));
        $oidc->setRedirectURL(url('/oidc-callback'));
        $oidc->authenticate();

        $access = true;

        $this->user = New User();
        $this->user->username = $oidc->requestUserInfo('given_name');

        //TODO: Return Authenticable (e.g. User-Object)
        if($access){
            return true;
        }else{
            return false;
        }
    }

    function getUser(){
        return $this->user;
    }

}

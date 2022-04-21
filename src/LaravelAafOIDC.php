<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jumbojett\OpenIDConnectClient;

class LaravelAafOIDC extends Controller
{
    private $user;
    private $route;

    function authenticate(){

        $this->route = Route::current();

        Log::info($this->route);

        $oidc = new OpenIDConnectClient(config('aaf-oidc.provider_url'),config('aaf-oidc.client_id'),config('aaf-oidc.client_secret'));
        $oidc->setRedirectURL(url('/oidc-callback'));
        $access = $oidc->authenticate();

        $this->user = New User();
        $this->user->username = $oidc->requestUserInfo('given_name');

        Auth::login($this->user);

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

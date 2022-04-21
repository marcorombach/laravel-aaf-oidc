<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jumbojett\OpenIDConnectClient;

class LaravelAafOIDC extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    private $user;

    function authenticate(){

        $oidc = new OpenIDConnectClient(config('aaf-oidc.provider_url'),config('aaf-oidc.client_id'),config('aaf-oidc.client_secret'));
        $oidc->setRedirectURL(url('/oidc-callback'));
        $access = $oidc->authenticate();

        $this->user = New User();
        $this->user->username = $oidc->requestUserInfo('user_name');

        Auth::login($this->user);

        if(config('aaf-oidc.post-login') != ''){
            return redirect()->route(config('aaf-oidc.post-login'));
        }
        return redirect(url('/'));
    }

    function getUser(){
        return $this->user;
    }

}

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
        $oidc->authenticate();

        Log::info('UserData: ' . json_encode($oidc->requestUserInfo()));

        $userdata = [
            'user_name' => $oidc->requestUserInfo('user_name'),
            'email' => $oidc->requestUserInfo('email'),
            'given_name' => $oidc->requestUserInfo('given_name'),
            'family_name' => $oidc->requestUserInfo('family_name')
        ];

        LoginHandler::handleLogin($userdata);

        if(config('aaf-oidc.post-login') != ''){
            return redirect()->route(config('aaf-oidc.post-login'));
        }
        return redirect(url('/'));
    }

}

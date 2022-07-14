<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Jumbojett\OpenIDConnectClient;
use Jumbojett\OpenIDConnectClientException;

class LaravelAafOIDC extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    function authenticate(){
        try {
            $oidc = new OpenIDConnectClient(config('aaf-oidc.provider_url'), config('aaf-oidc.client_id'), config('aaf-oidc.client_secret'));
            $oidc->setRedirectURL(url('/oidc-callback'));
            $oidc->addScope(['profile','email']);
            $authenticated = $oidc->authenticate();

            $userdata = [
                'user_name' => $oidc->requestUserInfo('preferred_username'),
                'email' => $oidc->requestUserInfo('email'),
                'given_name' => $oidc->requestUserInfo('given_name'),
                'family_name' => $oidc->requestUserInfo('family_name')
            ];

        }catch(OpenIDConnectClientException $e){
            Log::error($e->getMessage());
        }
        if($authenticated){
            LoginHandler::handleLogin($userdata);

            if(config('aaf-oidc.post-login') != ''){
                return redirect()->route(config('aaf-oidc.post-login'));
            }
            return redirect(url('/'));
        }
        if(config('aaf-oidc.error-route') != ''){
            return redirect()->route(config('aaf-oidc.error-route'));
        }
        return redirect(url('/'));
    }

}

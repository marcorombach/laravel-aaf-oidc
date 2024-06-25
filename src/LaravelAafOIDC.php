<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Jumbojett\OpenIDConnectClientException;

class LaravelAafOIDC extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    function authenticate(){
        try {
            $oidc = new LaravelOIDCClient(config('aaf-oidc.provider_url'), config('aaf-oidc.client_id'), config('aaf-oidc.client_secret'));
            $oidc->setRedirectURL(url('/oidc-callback'));
            $oidc->addScope(['profile','email']);
            $oidc->authenticate();
        }catch(OpenIDConnectClientException $e){
            Log::error($e->getMessage());
            if(config('aaf-oidc.error-route') != '') {
                return redirect()->route(config('aaf-oidc.error-route'))->with(['error' => $e->getMessage()]);
            }
            return redirect(url('/'))->with(['error' => $e->getMessage()]);
        }
    }

    function authenticateRedirect(Request $request){
        $_REQUEST = $request->query();
        try {
            $oidc = new LaravelOIDCClient(config('aaf-oidc.provider_url'), config('aaf-oidc.client_id'), config('aaf-oidc.client_secret'));
            $oidc->setRedirectURL(url('/oidc-callback'));
            $oidc->addScope(['profile','email']);
            $authenticated = $oidc->authenticate();
        }catch(OpenIDConnectClientException $e){
            $_REQUEST = [];
            Log::error($e->getMessage());
            if(config('aaf-oidc.error-route') != '') {
                return redirect()->route(config('aaf-oidc.error-route'))->with(['error' => $e->getMessage()]);
            }
            return redirect(url('/'))->with(['error' => $e->getMessage()]);
        }

        if($authenticated){
            try{
                $userdata = new UserData();
                $userdata->setUsername($oidc->requestUserInfo('preferred_username'));
                $userdata->setEmail($oidc->requestUserInfo('email'));
                $userdata->setGivenname($oidc->requestUserInfo('given_name'));
                $userdata->setFamilyname($oidc->requestUserInfo('family_name'));

                $_REQUEST = [];
                LoginHandler::handleLogin($userdata);
            }catch(\ErrorException $e){
                $_REQUEST = [];
                if(config('aaf-oidc.error-route') != '') {
                    return redirect()->route(config('aaf-oidc.error-route'))->with(['error' => $e->getMessage()]);
                }
                return redirect(url('/'))->with(['error' => $e->getMessage()]);
            }
            if(config('aaf-oidc.post-login-route') != ''){
                return redirect()->route(config('aaf-oidc.post-login-route'));
            }
            return redirect(url('/'));
        }
        if(config('aaf-oidc.error-route') != ''){
            $_REQUEST = [];
            Log::error("Authentication failed (authenticated = false)");
            return redirect()->route(config('aaf-oidc.error-route'))->with(['error' => 'Authentication failed']);
        }
        $_REQUEST = [];
        return redirect(url('/'))->with(['error' => 'Authentication failed']);
    }

}

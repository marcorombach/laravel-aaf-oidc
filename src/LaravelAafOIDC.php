<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Jumbojett\OpenIDConnectClientException;

class LaravelAafOIDC extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    private $oidc;

    public function __construct()
    {
        $this->oidc = new LaravelOIDCClient(config('aaf-oidc.provider_url'), config('aaf-oidc.client_id'), config('aaf-oidc.client_secret'));
    }

    function authenticate(){
        try {
            $this->oidc->setRedirectURL(url('/oidc-callback'));
            $this->oidc->addScope(['profile','email']);
            $this->oidc->authenticate();
        }catch(OpenIDConnectClientException $e){
            Log::error($e->getMessage());
            if(config('aaf-oidc.error-route') != '') {
                return redirect()->route(config('aaf-oidc.error-route'))->with(['error' => $e->getMessage()]);
            }
            return redirect(url('/'))->with(['error' => $e->getMessage()]);
        }
    }

    function authenticateRedirect(){
        try {
            $authenticated = $this->oidc->authenticate();
        }catch(OpenIDConnectClientException $e){
            Log::error($e->getMessage());
            if(config('aaf-oidc.error-route') != '') {
                return redirect()->route(config('aaf-oidc.error-route'))->with(['error' => $e->getMessage()]);
            }
            return redirect(url('/'))->with(['error' => $e->getMessage()]);
        }

        if($authenticated){
            try{
                $userdata = new UserData();
                $userdata->setUsername($this->oidc->requestUserInfo('preferred_username'));
                $userdata->setEmail($this->oidc->requestUserInfo('email'));
                $userdata->setGivenname($this->oidc->requestUserInfo('given_name'));
                $userdata->setFamilyname($this->oidc->requestUserInfo('family_name'));

                LoginHandler::handleLogin($userdata);
            }catch(\ErrorException $e){
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
            Log::error("Authentication failed (authenticated = false)");
            return redirect()->route(config('aaf-oidc.error-route'))->with(['error' => 'Authentication failed']);
        }
        return redirect(url('/'))->with(['error' => 'Authentication failed']);
    }

}

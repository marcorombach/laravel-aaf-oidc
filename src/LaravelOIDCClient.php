<?php

namespace Marcorombach\LaravelAafOIDC;
use Jumbojett\OpenIDConnectClient;
class LaravelOIDCClient extends OpenIDConnectClient{

    public function redirect(string $url) {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect($url));
    }

}

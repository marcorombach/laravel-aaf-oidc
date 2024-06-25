<?php

namespace Marcorombach\LaravelAafOIDC;
use Jumbojett\OpenIDConnectClient;
class LaravelOIDCClient extends OpenIDConnectClient{

    public function redirect(string $url) {
        return redirect()->away($url);
    }

}

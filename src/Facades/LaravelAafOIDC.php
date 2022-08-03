<?php

namespace Marcorombach\LaravelAafOIDC\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Marcorombach\LaravelAafOIDC\LaravelAafOIDC
 */
class LaravelAafOIDC extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-aaf-oidc';
    }
}

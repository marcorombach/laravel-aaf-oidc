<?php
Route::group(['middleware' => ['web']], function () {
    Route::get('oidc-callback', [\Marcorombach\LaravelAafOIDC\LaravelAafOIDC::class, 'authenticateRedirect']);
    Route::get('oidc-login', [\Marcorombach\LaravelAafOIDC\LaravelAafOIDC::class, 'authenticate']);
});


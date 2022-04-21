<?php
Route::group(['middleware' => ['web']], function () {
    Route::post('oidc-callback', [\Marcorombach\LaravelAafOIDC\LaravelAafOIDC::class, 'authenticate']);
    Route::get('oidc-callback', [\Marcorombach\LaravelAafOIDC\LaravelAafOIDC::class, 'authenticate']);
});


<?php

Route::post('oidc-callback', [\Marcorombach\LaravelAafOIDC\LaravelAafOIDC::class, 'authenticate']);
Route::get('oidc-callback', [\Marcorombach\LaravelAafOIDC\LaravelAafOIDC::class, 'authenticate']);


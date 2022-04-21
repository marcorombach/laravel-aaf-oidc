<?php

Route::post('oidc-callback', 'LaravelAafOIDC@authenticate');
Route::get('oidc-callback', 'LaravelAafOIDC@authenticate');


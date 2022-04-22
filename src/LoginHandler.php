<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Jumbojett\OpenIDConnectClient;

class LoginHandler
{
    static function handleLogin($userdata){

        $user = new User();
        $table = $user->getTable();
        $columns = \Schema::getColumnListing($table);

        if (in_array('username', $columns)) {
            $user = User::where('username', $userdata['user_name'])->first();
        }elseif (in_array('email', $columns)){
            $user = User::where('email', $userdata['email'])->first();
        }

        if(!$user) {
            Log::info("AAF-OIDC: Creating User");
            $user = new User();
            $table = $user->getTable();
            $columns = \Schema::getColumnListing($table);

            if (in_array('username', $columns)) {
                $user->username = data_get($userdata,'user_name');
            }
            if (in_array('name', $columns) && in_array('givenname', $columns)) {
                $user->name = data_get($userdata,'family_name');
            } elseif (in_array('name', $columns)) {
                $user->name = data_get($userdata,'given_name') . " " . data_get($userdata,'family_name');
            }
            if (in_array('email', $columns)) {
                $user->email = data_get($userdata,'email');
            }
            if (in_array('givenname', $columns)) {
                $user->givenname = data_get($userdata,'given_name');
            }
            if (in_array('fullname', $columns)) {
                $user->fullname = data_get($userdata,'given_name') . " " . data_get($userdata,'family_name');
            }
            if (in_array('password', $columns)) {
                $user->password = Str::random(32);
            }

            $user->save();
        }
        Log::info("AAF-OIDC: Logging In");
        Auth::login($user);
    }
}

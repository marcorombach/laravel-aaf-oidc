<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jumbojett\OpenIDConnectClient;

class LoginHandler
{
    static function handleLogin($userdata){
        $user = User::where('username', $userdata['user_name'])->orWhere('email', $userdata['email'])->first();

        if(!$user) {
            Log::info("Creating User");
            $user = new User();
            $table = $user->getTable();
            $columns = \Schema::getColumnListing($table);

            if (in_array('username', $columns)) {
                $user->username = $userdata['user_name'];
            }
            if (in_array('name', $columns) && in_array('givenname', $columns)) {
                $user->name = $userdata['family_name'];
            } elseif (in_array('name', $columns)) {
                $user->name = $userdata['given_name'] . " " . $userdata['family_name'];
            }
            if (in_array('email', $columns)) {
                $user->email = $userdata['email'];
            }
            if (in_array('givenname', $columns)) {
                $user->givenname = $userdata['given_name'];
            }
            if (in_array('fullname', $columns)) {
                $user->fullname = $userdata['given_name'] . " " . $userdata['family_name'];
            }
            $user->save();
        }
        Log::info("Logging In");
        Auth::login($user);
    }
}

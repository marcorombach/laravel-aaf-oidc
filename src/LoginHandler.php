<?php

namespace Marcorombach\LaravelAafOIDC;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginHandler
{
    /**
     * @param $userdata UserData
     */
    static function handleLogin(UserData $userdata): void
    {
        $user = new User();
        $table = $user->getTable();
        $columns = \Schema::getColumnListing($table);

        if(!in_array('username', $columns) && in_array('email', $columns)){
            throw new \ErrorException('User Table is not compatible. No username or email field.');
        }

        if (in_array('username', $columns)) {
            $user = User::where('username', $userdata->getUsername())->first();
        }elseif (in_array('email', $columns)){
            $user = User::where('email', $userdata->getEmail())->first();
        }

        if(!$user) {
            Log::info("AAF-OIDC: Creating User");
            $user = new User();
            $table = $user->getTable();
            $columns = \Schema::getColumnListing($table);

            if (in_array('username', $columns)) {
                $user->username = $userdata->getUsername();
            }
            if (in_array('email', $columns)) {
                $user->email = $userdata->getEmail();
            }
            if (in_array('name', $columns) && in_array('givenname', $columns)) {
                $user->name = $userdata->getFamilyname();
            } elseif (in_array('name', $columns)) {
                $user->name = $userdata->getFullname();
            }
            if (in_array('givenname', $columns)) {
                $user->givenname = $userdata->getGivenname();
            }
            if (in_array('fullname', $columns)) {
                $user->fullname = $userdata->getFullname();
            }
            if (in_array('password', $columns)) {
                $user->password = Str::random(32);
            }

            $user->save();
        }
        Log::info("AAF-OIDC: Logging In");
        Auth::login($user);
        Log::info("AAF-OIDC: Session - " . json_encode(session()->all()));
    }
}

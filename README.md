# laravel-aaf-radius

This Laravel Package provides a simple way to authenticate with OpenID Connect.
Minimum requirement is a User Model/Table which has either a field 'username' or a field 'email'.
It's recommended to define a post login route and a error route.
The error route is called with a flashed session variable (session('error')) containing information to display.

To configure this package with NetIQ Advanced Authentication, a Event must be created.
The ClientID and Client Secret you get there must be entered in the corresponding field in the configuration file of this package.
The provider_url in the config hast to be set like this: https://<aaf-domainname>/osp/a/<tenant>/auth/oauth2
All needed Endpoints will be automatically retrieved from https://<aaf-domainname>/osp/a/<tenant>/auth/oauth2/.well-known/openid-configuration

## Installation

Install the package via composer:

```bash
composer require marcorombach/laravel-aaf-oidc
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="aaf-oidc-config"
```

This is the contents of the published config file:

```php
return [
    'provider_url' => '', //issuer URL of the auth provider -> https://<aaf-domainname>/osp/a/<tenant>/auth/oauth2
    'client_secret' => '', //Client secret
    'client_id' => '', //Client ID
    'post-login-route' => '', //Route to redirect to after login - if not set you will be redirected to the base URL
    'error-route' => '', //Route to redirect to on login error - redirects with $error variable set
];
```


## Usage

```php
$laravelAafOIDC = new Marcorombach\LaravelAafOIDC();
$authenticatable = $laravelAafOIDC->authenticate();
```

The redirect URI is your applications base URI + /oidc-callback - this has to be set in the AAF Event

It's not necessary to use the class directly. Laravel-AAF-SAML provides a route which starts the authentication process.

```
/saml-login
```

## Credits

- [Marco Rombach](https://github.com/marcorombach)

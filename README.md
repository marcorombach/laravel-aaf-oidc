# laravel-aaf-radius

-- TODO --

## Installation

Install the package via composer:

```bash
composer require marcorombach/laravel-aaf-oidc
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-aaf-oidc-config"
```

This is the contents of the published config file:

```php
return [

];
```


## Usage

```php
$laravelAafOIDC = new Marcorombach\LaravelAafOIDC();
$authenticatable = $laravelAafOIDC->authenticate();
```

The redirect URI is your applications base URI + /oidc-callback

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Marco Rombach](https://github.com/marcorombach)

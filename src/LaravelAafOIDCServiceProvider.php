<?php

namespace Marcorombach\LaravelAafOIDC;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAafOIDCServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-aaf-oidc')
            ->hasRoute('web')
            ->hasConfigFile();
    }
}

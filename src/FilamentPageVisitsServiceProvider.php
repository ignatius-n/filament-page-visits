<?php

namespace JeffersonGoncalves\Filament\PageVisits;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentPageVisitsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-page-visits';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations();
    }
}

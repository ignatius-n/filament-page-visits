<?php

use Filament\Contracts\Plugin;
use JeffersonGoncalves\Filament\PageVisits\FilamentPageVisitsPlugin;

it('has the correct id', function () {
    expect(FilamentPageVisitsPlugin::make()->getId())->toBe('filament-page-visits');
});

it('implements the Filament Plugin contract', function () {
    expect(FilamentPageVisitsPlugin::make())->toBeInstanceOf(Plugin::class);
});

it('make() returns an instance', function () {
    expect(FilamentPageVisitsPlugin::make())->toBeInstanceOf(FilamentPageVisitsPlugin::class);
});

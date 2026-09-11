<?php

namespace JeffersonGoncalves\Filament\PageVisits\Concerns;

use JeffersonGoncalves\Filament\PageVisits\FilamentPageVisitsPlugin;

/**
 * Every resource/page this plugin registers shares one navigation group so
 * they cluster together in the sidebar instead of scattering across the
 * host panel's other groups. FilamentPageVisitsPlugin::navigationGroup()
 * overrides it panel-wide; unset, it falls back to a translated default.
 */
trait HasPluginNavigationGroup
{
    public static function getNavigationGroup(): ?string
    {
        return FilamentPageVisitsPlugin::get()->getNavigationGroup();
    }
}

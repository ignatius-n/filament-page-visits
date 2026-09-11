<?php

namespace JeffersonGoncalves\Filament\PageVisits\Support;

class Utils
{
    public static function getMetricsPageSlug(): string
    {
        return (string) config('filament-page-visits.metrics_page.slug', 'page-visits-metrics');
    }
}

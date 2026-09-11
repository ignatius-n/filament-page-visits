<?php

namespace JeffersonGoncalves\Filament\PageVisits\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\Filament\PageVisits\Concerns\HasPluginNavigationGroup;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\HourlyChart;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\StatsOverview;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\TopPages;
use JeffersonGoncalves\Filament\PageVisits\Support\Utils;

class MetricsPage extends Page
{
    use HasPluginNavigationGroup;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    public static function getSlug(?Panel $panel = null): string
    {
        return Utils::getMetricsPageSlug();
    }

    public function getTitle(): string
    {
        return __('filament-page-visits::resources/page-visit.metrics.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-page-visits::resources/page-visit.metrics.title');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            HourlyChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            TopPages::class,
        ];
    }
}

<?php

namespace JeffersonGoncalves\Filament\PageVisits\Pages;

use Filament\Pages\Page;
use JeffersonGoncalves\Filament\PageVisits\Concerns\HasPluginNavigationGroup;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\HourlyChart;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\StatsOverview;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\TopPages;

class MetricsPage extends Page
{
    use HasPluginNavigationGroup;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament-page-visits::pages.metrics-page';

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

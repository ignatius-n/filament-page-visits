<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages;

use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\HourlyChart;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\StatsOverview;

class ListPageVisits extends ListRecords
{
    protected static string $resource = PageVisitResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            HourlyChart::class,
        ];
    }
}

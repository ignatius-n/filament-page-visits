<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class SecurityOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $total = PageVisit::query()->count();

        $percentage = fn (int $count): string => ($total > 0 ? round($count / $total * 100, 1) : 0.0).'%';

        $vpn = PageVisit::query()->where('is_vpn', true)->count();
        $proxy = PageVisit::query()->where('is_proxy', true)->count();
        $tor = PageVisit::query()->where('is_tor', true)->count();
        $datacenter = PageVisit::query()->where('is_datacenter', true)->count();

        return [
            Stat::make(__('filament-page-visits::resources/page-visit.fields.is_vpn'), $percentage($vpn)),
            Stat::make(__('filament-page-visits::resources/page-visit.fields.is_proxy'), $percentage($proxy)),
            Stat::make(__('filament-page-visits::resources/page-visit.fields.is_tor'), $percentage($tor)),
            Stat::make(__('filament-page-visits::resources/page-visit.fields.is_datacenter'), $percentage($datacenter)),
        ];
    }
}

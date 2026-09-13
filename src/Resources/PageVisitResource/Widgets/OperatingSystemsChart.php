<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Widgets\ChartWidget;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class OperatingSystemsChart extends ChartWidget
{
    protected static ?string $pollingInterval = null;

    public function getHeading(): ?string
    {
        return __('filament-page-visits::resources/page-visit.stats.operating_systems');
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $counts = PageVisit::query()
            ->selectRaw('coalesce(operating_system, ?) as operating_system, count(*) as aggregate', [
                __('filament-page-visits::resources/page-visit.stats.unknown'),
            ])
            ->groupBy('operating_system')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'operating_system');

        return [
            'datasets' => [
                [
                    'data' => $counts->values()->all(),
                    'backgroundColor' => ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9', '#a855f7'],
                ],
            ],
            'labels' => $counts->keys()->all(),
        ];
    }
}

<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Widgets\ChartWidget;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class DevicesChart extends ChartWidget
{
    protected static ?string $pollingInterval = null;

    public function getHeading(): ?string
    {
        return __('filament-page-visits::resources/page-visit.stats.devices');
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $counts = PageVisit::query()
            ->selectRaw('coalesce(device_type, ?) as device_type, count(*) as aggregate', [
                __('filament-page-visits::resources/page-visit.stats.unknown'),
            ])
            ->groupBy('device_type')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'device_type');

        return [
            'datasets' => [
                [
                    'data' => $counts->values()->all(),
                    'backgroundColor' => ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9'],
                ],
            ],
            'labels' => $counts->keys()->all(),
        ];
    }
}

<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Widgets\ChartWidget;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class BrowsersChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    public function getHeading(): ?string
    {
        return __('filament-page-visits::resources/page-visit.stats.browsers');
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $counts = PageVisit::query()
            ->selectRaw('coalesce(browser, ?) as browser, count(*) as aggregate', [
                __('filament-page-visits::resources/page-visit.stats.unknown'),
            ])
            ->groupBy('browser')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'browser');

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

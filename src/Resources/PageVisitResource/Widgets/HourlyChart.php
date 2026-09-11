<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Widgets\ChartWidget;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class HourlyChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    public function getHeading(): ?string
    {
        return __('filament-page-visits::resources/page-visit.stats.hourly');
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $counts = PageVisit::query()
            ->where('visited_at', '>=', now()->subHours(23)->startOfHour())
            ->get(['visited_at'])
            ->groupBy(fn (PageVisit $visit): int => (int) $visit->visited_at->format('H'))
            ->map->count();

        $labels = range(0, 23);

        return [
            'datasets' => [
                [
                    'label' => __('filament-page-visits::resources/page-visit.stats.total_visits'),
                    'data' => array_map(fn (int $hour): int => $counts[$hour] ?? 0, $labels),
                    'backgroundColor' => '#6366f1',
                ],
            ],
            'labels' => array_map(fn (int $hour): string => sprintf('%02d:00', $hour), $labels),
        ];
    }
}

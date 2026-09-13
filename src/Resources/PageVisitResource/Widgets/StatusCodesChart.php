<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class StatusCodesChart extends ChartWidget
{
    protected static ?string $pollingInterval = null;

    public function getHeading(): ?string
    {
        return __('filament-page-visits::resources/page-visit.stats.status_codes');
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        // Repeat the CASE expression (rather than group by its alias) so the
        // query stays portable across MySQL/Postgres/SQLite — grouping by an
        // output alias isn't standard SQL and Postgres in particular rejects it.
        $statusGroup = "CASE
            WHEN status_code IS NULL THEN 'unknown'
            WHEN status_code BETWEEN 200 AND 299 THEN '2xx'
            WHEN status_code BETWEEN 300 AND 399 THEN '3xx'
            WHEN status_code BETWEEN 400 AND 499 THEN '4xx'
            WHEN status_code BETWEEN 500 AND 599 THEN '5xx'
            ELSE 'other'
        END";

        $counts = PageVisit::query()
            ->selectRaw("{$statusGroup} as status_group, count(*) as aggregate")
            ->groupBy(DB::raw($statusGroup))
            ->pluck('aggregate', 'status_group');

        $labels = ['2xx', '3xx', '4xx', '5xx', 'unknown', 'other'];

        return [
            'datasets' => [
                [
                    'label' => __('filament-page-visits::resources/page-visit.stats.total_visits'),
                    'data' => array_map(fn (string $label): int => (int) ($counts[$label] ?? 0), $labels),
                    'backgroundColor' => ['#22c55e', '#0ea5e9', '#f59e0b', '#ef4444', '#94a3b8', '#a855f7'],
                ],
            ],
            'labels' => $labels,
        ];
    }
}

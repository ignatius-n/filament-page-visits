<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class TopAsn extends TableWidget
{
    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        /** @var Builder<PageVisit> $query */
        $query = PageVisit::query()
            ->whereNotNull('asn')
            ->select(['asn', 'isp', DB::raw('max(id) as id'), DB::raw('count(*) as visits_count')])
            ->groupBy(['asn', 'isp'])
            ->orderByDesc('visits_count')
            ->limit(10);

        return $table
            ->heading(__('filament-page-visits::resources/page-visit.stats.top_asn'))
            ->query($query)
            // Same Postgres GROUP BY constraint as TopPages — see that class.
            ->defaultKeySort(false)
            ->paginated(false)
            ->columns([
                TextColumn::make('asn')
                    ->label(__('filament-page-visits::resources/page-visit.fields.asn')),

                TextColumn::make('isp')
                    ->label(__('filament-page-visits::resources/page-visit.fields.isp')),

                TextColumn::make('visits_count')
                    ->label(__('filament-page-visits::resources/page-visit.stats.total_visits'))
                    ->badge(),
            ]);
    }
}

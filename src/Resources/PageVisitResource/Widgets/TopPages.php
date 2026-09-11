<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class TopPages extends TableWidget
{
    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        /** @var Builder<PageVisit> $query */
        $query = PageVisit::query()
            ->select(['path', DB::raw('max(id) as id'), DB::raw('count(*) as visits_count')])
            ->groupBy('path')
            ->orderByDesc('visits_count')
            ->limit(10);

        return $table
            ->heading(__('filament-page-visits::resources/page-visit.stats.top_pages'))
            ->query($query)
            ->paginated(false)
            ->columns([
                TextColumn::make('path')
                    ->label(__('filament-page-visits::resources/page-visit.fields.path'))
                    ->limit(60),

                TextColumn::make('visits_count')
                    ->label(__('filament-page-visits::resources/page-visit.stats.total_visits'))
                    ->badge(),
            ]);
    }
}

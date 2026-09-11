<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Tables;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class PageVisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (PageVisit $record): string => PageVisitResource::getUrl('view', ['record' => $record]))
            ->defaultSort('visited_at', 'desc')
            ->columns([
                TextColumn::make('visited_at')
                    ->label(__('filament-page-visits::resources/page-visit.fields.visited_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('path')
                    ->label(__('filament-page-visits::resources/page-visit.fields.path'))
                    ->limit(40)
                    ->tooltip(fn (PageVisit $record): string => $record->path)
                    ->searchable(),

                TextColumn::make('method')
                    ->label(__('filament-page-visits::resources/page-visit.fields.method'))
                    ->badge(),

                TextColumn::make('status_code')
                    ->label(__('filament-page-visits::resources/page-visit.fields.status_code'))
                    ->badge()
                    ->color(fn (?int $state): string => match (true) {
                        $state === null => 'gray',
                        $state < 300 => 'success',
                        $state < 400 => 'info',
                        default => 'danger',
                    }),

                TextColumn::make('device_type')
                    ->label(__('filament-page-visits::resources/page-visit.fields.device_type')),

                TextColumn::make('browser')
                    ->label(__('filament-page-visits::resources/page-visit.fields.browser'))
                    ->description(fn (PageVisit $record): ?string => $record->browser_version),

                TextColumn::make('operating_system')
                    ->label(__('filament-page-visits::resources/page-visit.fields.operating_system'))
                    ->description(fn (PageVisit $record): ?string => $record->operating_system_version),

                TextColumn::make('country')
                    ->label(__('filament-page-visits::resources/page-visit.fields.country'))
                    ->description(fn (PageVisit $record): ?string => $record->country_code),

                TextColumn::make('referer_type')
                    ->label(__('filament-page-visits::resources/page-visit.fields.referer_type'))
                    ->badge(),

                IconColumn::make('is_bot')
                    ->label(__('filament-page-visits::resources/page-visit.fields.is_bot'))
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_bot')
                    ->label(__('filament-page-visits::resources/page-visit.fields.is_bot')),

                SelectFilter::make('device_type')
                    ->label(__('filament-page-visits::resources/page-visit.fields.device_type'))
                    ->options(fn (): array => PageVisit::query()
                        ->whereNotNull('device_type')
                        ->distinct()
                        ->pluck('device_type', 'device_type')
                        ->all()),

                SelectFilter::make('method')
                    ->label(__('filament-page-visits::resources/page-visit.fields.method'))
                    ->options(fn (): array => PageVisit::query()
                        ->distinct()
                        ->pluck('method', 'method')
                        ->all()),

                Filter::make('visited_at')
                    ->schema([
                        DatePicker::make('visited_from')
                            ->label(__('filament-page-visits::resources/page-visit.filters.visited_from')),
                        DatePicker::make('visited_until')
                            ->label(__('filament-page-visits::resources/page-visit.filters.visited_until')),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['visited_from'] ?? null, fn (Builder $q, string $date) => $q->whereDate('visited_at', '>=', $date))
                        ->when($data['visited_until'] ?? null, fn (Builder $q, string $date) => $q->whereDate('visited_at', '<=', $date))),
            ]);
    }
}

<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Filament\PageVisits\Concerns\HasPluginNavigationGroup;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ListPageVisits;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ViewPageVisit;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class PageVisitResource extends Resource
{
    use HasPluginNavigationGroup;

    protected static ?string $model = PageVisit::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public static function getNavigationLabel(): string
    {
        return __('filament-page-visits::resources/page-visit.navigation.label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-page-visits::resources/page-visit.navigation.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-page-visits::resources/page-visit.navigation.label');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (PageVisit $record): string => static::getUrl('view', ['record' => $record]))
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
                    ->form([
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfolistSection::make(__('filament-page-visits::resources/page-visit.sections.request'))
                ->columns(3)
                ->schema([
                    TextEntry::make('path')->label(__('filament-page-visits::resources/page-visit.fields.path')),
                    TextEntry::make('route_name')->label(__('filament-page-visits::resources/page-visit.fields.route_name'))->placeholder('—'),
                    TextEntry::make('method')->label(__('filament-page-visits::resources/page-visit.fields.method'))->badge(),
                    TextEntry::make('status_code')->label(__('filament-page-visits::resources/page-visit.fields.status_code'))->badge(),
                    TextEntry::make('visited_at')->label(__('filament-page-visits::resources/page-visit.fields.visited_at'))->dateTime(),
                    TextEntry::make('response_time_ms')->label(__('filament-page-visits::resources/page-visit.fields.response_time_ms'))->suffix(' ms')->placeholder('—'),
                ]),

            InfolistSection::make(__('filament-page-visits::resources/page-visit.sections.device'))
                ->columns(3)
                ->schema([
                    TextEntry::make('device_type')->label(__('filament-page-visits::resources/page-visit.fields.device_type'))->placeholder('—'),
                    TextEntry::make('browser')->label(__('filament-page-visits::resources/page-visit.fields.browser'))->placeholder('—'),
                    TextEntry::make('browser_version')->label(__('filament-page-visits::resources/page-visit.fields.browser_version'))->placeholder('—'),
                    TextEntry::make('operating_system')->label(__('filament-page-visits::resources/page-visit.fields.operating_system'))->placeholder('—'),
                    TextEntry::make('operating_system_version')->label(__('filament-page-visits::resources/page-visit.fields.operating_system_version'))->placeholder('—'),
                    TextEntry::make('browser_language')->label(__('filament-page-visits::resources/page-visit.fields.browser_language'))->placeholder('—'),
                    TextEntry::make('locale')->label(__('filament-page-visits::resources/page-visit.fields.locale'))->placeholder('—'),
                ]),

            InfolistSection::make(__('filament-page-visits::resources/page-visit.sections.location'))
                ->columns(3)
                ->schema([
                    TextEntry::make('country')->label(__('filament-page-visits::resources/page-visit.fields.country'))->placeholder('—'),
                    TextEntry::make('country_code')->label(__('filament-page-visits::resources/page-visit.fields.country_code'))->placeholder('—'),
                    TextEntry::make('region')->label(__('filament-page-visits::resources/page-visit.fields.region'))->placeholder('—'),
                    TextEntry::make('city')->label(__('filament-page-visits::resources/page-visit.fields.city'))->placeholder('—'),
                    TextEntry::make('latitude')->label(__('filament-page-visits::resources/page-visit.fields.latitude'))->placeholder('—'),
                    TextEntry::make('longitude')->label(__('filament-page-visits::resources/page-visit.fields.longitude'))->placeholder('—'),
                    TextEntry::make('timezone')->label(__('filament-page-visits::resources/page-visit.fields.timezone'))->placeholder('—'),
                    TextEntry::make('isp')->label(__('filament-page-visits::resources/page-visit.fields.isp'))->placeholder('—'),
                    TextEntry::make('asn')->label(__('filament-page-visits::resources/page-visit.fields.asn'))->placeholder('—'),
                ]),

            InfolistSection::make(__('filament-page-visits::resources/page-visit.sections.referer_utm'))
                ->columns(2)
                ->schema([
                    TextEntry::make('referer_url')->label(__('filament-page-visits::resources/page-visit.fields.referer_url'))->placeholder('—')->columnSpanFull(),
                    TextEntry::make('referer_host')->label(__('filament-page-visits::resources/page-visit.fields.referer_host'))->placeholder('—'),
                    TextEntry::make('referer_type')->label(__('filament-page-visits::resources/page-visit.fields.referer_type'))->badge()->placeholder('—'),
                    TextEntry::make('utm_source')->label(__('filament-page-visits::resources/page-visit.fields.utm_source'))->placeholder('—'),
                    TextEntry::make('utm_medium')->label(__('filament-page-visits::resources/page-visit.fields.utm_medium'))->placeholder('—'),
                    TextEntry::make('utm_campaign')->label(__('filament-page-visits::resources/page-visit.fields.utm_campaign'))->placeholder('—'),
                    TextEntry::make('utm_term')->label(__('filament-page-visits::resources/page-visit.fields.utm_term'))->placeholder('—'),
                    TextEntry::make('utm_content')->label(__('filament-page-visits::resources/page-visit.fields.utm_content'))->placeholder('—'),
                ]),

            InfolistSection::make(__('filament-page-visits::resources/page-visit.sections.risk'))
                ->columns(5)
                ->schema([
                    IconEntry::make('is_bot')->label(__('filament-page-visits::resources/page-visit.fields.is_bot'))->boolean(),
                    IconEntry::make('is_vpn')->label(__('filament-page-visits::resources/page-visit.fields.is_vpn'))->boolean(),
                    IconEntry::make('is_proxy')->label(__('filament-page-visits::resources/page-visit.fields.is_proxy'))->boolean(),
                    IconEntry::make('is_tor')->label(__('filament-page-visits::resources/page-visit.fields.is_tor'))->boolean(),
                    IconEntry::make('is_datacenter')->label(__('filament-page-visits::resources/page-visit.fields.is_datacenter'))->boolean(),
                ]),

            InfolistSection::make(__('filament-page-visits::resources/page-visit.sections.fingerprint'))
                ->description(__('filament-page-visits::resources/page-visit.sections.fingerprint_helper'))
                ->columns(2)
                ->schema([
                    TextEntry::make('ip_hash')->label(__('filament-page-visits::resources/page-visit.fields.ip_hash'))->placeholder('—'),
                    TextEntry::make('ip_anonymized')->label(__('filament-page-visits::resources/page-visit.fields.ip_anonymized'))->placeholder('—'),
                    TextEntry::make('ip_version')->label(__('filament-page-visits::resources/page-visit.fields.ip_version'))->placeholder('—'),
                    TextEntry::make('user_agent_hash')->label(__('filament-page-visits::resources/page-visit.fields.user_agent_hash'))->placeholder('—'),
                ]),
        ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageVisits::route('/'),
            'view' => ViewPageVisit::route('/{record}'),
        ];
    }
}

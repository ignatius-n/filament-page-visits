<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Filament\PageVisits\Concerns\HasPluginNavigationGroup;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ListPageVisits;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ViewPageVisit;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Schemas\PageVisitInfolist;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Tables\PageVisitsTable;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

class PageVisitResource extends Resource
{
    use HasPluginNavigationGroup;

    protected static ?string $model = PageVisit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEye;

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
        return PageVisitsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PageVisitInfolist::configure($schema);
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

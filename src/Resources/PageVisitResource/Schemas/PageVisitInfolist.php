<?php

namespace JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageVisitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-page-visits::resources/page-visit.sections.request'))
                ->columns(3)
                ->schema([
                    TextEntry::make('path')->label(__('filament-page-visits::resources/page-visit.fields.path')),
                    TextEntry::make('route_name')->label(__('filament-page-visits::resources/page-visit.fields.route_name'))->placeholder('—'),
                    TextEntry::make('method')->label(__('filament-page-visits::resources/page-visit.fields.method'))->badge(),
                    TextEntry::make('status_code')->label(__('filament-page-visits::resources/page-visit.fields.status_code'))->badge(),
                    TextEntry::make('visited_at')->label(__('filament-page-visits::resources/page-visit.fields.visited_at'))->dateTime(),
                    TextEntry::make('response_time_ms')->label(__('filament-page-visits::resources/page-visit.fields.response_time_ms'))->suffix(' ms')->placeholder('—'),
                ]),

            Section::make(__('filament-page-visits::resources/page-visit.sections.device'))
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

            Section::make(__('filament-page-visits::resources/page-visit.sections.location'))
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

            Section::make(__('filament-page-visits::resources/page-visit.sections.referer_utm'))
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

            Section::make(__('filament-page-visits::resources/page-visit.sections.risk'))
                ->columns(5)
                ->schema([
                    IconEntry::make('is_bot')->label(__('filament-page-visits::resources/page-visit.fields.is_bot'))->boolean(),
                    IconEntry::make('is_vpn')->label(__('filament-page-visits::resources/page-visit.fields.is_vpn'))->boolean(),
                    IconEntry::make('is_proxy')->label(__('filament-page-visits::resources/page-visit.fields.is_proxy'))->boolean(),
                    IconEntry::make('is_tor')->label(__('filament-page-visits::resources/page-visit.fields.is_tor'))->boolean(),
                    IconEntry::make('is_datacenter')->label(__('filament-page-visits::resources/page-visit.fields.is_datacenter'))->boolean(),
                ]),

            Section::make(__('filament-page-visits::resources/page-visit.sections.fingerprint'))
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
}

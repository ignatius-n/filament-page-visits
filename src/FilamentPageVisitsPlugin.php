<?php

namespace JeffersonGoncalves\Filament\PageVisits;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\Filament\PageVisits\Pages\MetricsPage;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource;

class FilamentPageVisitsPlugin implements Plugin
{
    protected ?string $navigationGroup = null;

    public function getId(): string
    {
        return 'filament-page-visits';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                PageVisitResource::class,
            ])
            ->pages([
                MetricsPage::class,
            ]);
    }

    public function boot(Panel $panel): void {}

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function navigationGroup(?string $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function getNavigationGroup(): ?string
    {
        return $this->navigationGroup ?? __('filament-page-visits::resources/page-visit.navigation.group');
    }
}

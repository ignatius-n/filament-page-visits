<?php

use JeffersonGoncalves\Filament\PageVisits\FilamentPageVisitsPlugin;
use JeffersonGoncalves\Filament\PageVisits\Pages\MetricsPage;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ListPageVisits;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ViewPageVisit;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\HourlyChart;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\StatsOverview;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\TopPages;
use JeffersonGoncalves\Filament\PageVisits\Tests\Factories\PageVisitFactory;
use JeffersonGoncalves\Filament\PageVisits\Tests\Factories\UserFactory;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->admin = UserFactory::new()->create();

    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->actingAs($this->admin);
});

it('can render the list page', function () {
    livewire(ListPageVisits::class)->assertSuccessful();
});

it('lists the expected table columns', function () {
    $visit = PageVisitFactory::new()->create(['path' => '/listme']);

    livewire(ListPageVisits::class)
        ->assertCanSeeTableRecords([$visit])
        ->assertTableColumnExists('visited_at')
        ->assertTableColumnExists('path')
        ->assertTableColumnExists('method')
        ->assertTableColumnExists('status_code')
        ->assertTableColumnExists('device_type')
        ->assertTableColumnExists('browser')
        ->assertTableColumnExists('operating_system')
        ->assertTableColumnExists('country')
        ->assertTableColumnExists('referer_type')
        ->assertTableColumnExists('is_bot');
});

it('can render the view page', function () {
    $visit = PageVisitFactory::new()->create();

    livewire(ViewPageVisit::class, ['record' => $visit->getRouteKey()])->assertSuccessful();
});

it('can render the dedicated metrics page', function () {
    PageVisitFactory::new()->create();

    livewire(MetricsPage::class)->assertSuccessful();
});

it('renders the metrics widgets without polling', function () {
    PageVisitFactory::new()->create();

    livewire(StatsOverview::class)->assertSuccessful()->assertDontSee('wire:poll', escape: false);
    livewire(HourlyChart::class)->assertSuccessful()->assertDontSee('wire:poll', escape: false);
    livewire(TopPages::class)->assertSuccessful()->assertDontSee('wire:poll', escape: false);
});

it('defaults the navigation group to the translated label and allows overriding it', function () {
    $plugin = FilamentPageVisitsPlugin::get();

    expect(PageVisitResource::getNavigationGroup())->toBe(__('filament-page-visits::resources/page-visit.navigation.group'))
        ->and(MetricsPage::getNavigationGroup())->toBe(__('filament-page-visits::resources/page-visit.navigation.group'));

    $plugin->navigationGroup('Custom Group');

    expect(PageVisitResource::getNavigationGroup())->toBe('Custom Group')
        ->and(MetricsPage::getNavigationGroup())->toBe('Custom Group');

    $plugin->navigationGroup(null);
});

it('is a read-only resource', function () {
    $visit = PageVisitFactory::new()->create();

    expect(PageVisitResource::canCreate())->toBeFalse()
        ->and(PageVisitResource::canEdit($visit))->toBeFalse()
        ->and(PageVisitResource::canDelete($visit))->toBeFalse()
        ->and(PageVisitResource::canDeleteAny())->toBeFalse();
});

<?php

use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ListPageVisits;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Pages\ViewPageVisit;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\HourlyChart;
use JeffersonGoncalves\Filament\PageVisits\Resources\PageVisitResource\Widgets\StatsOverview;
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

it('renders the header widgets', function () {
    PageVisitFactory::new()->create();

    livewire(StatsOverview::class)->assertSuccessful();
    livewire(HourlyChart::class)->assertSuccessful();
});

it('is a read-only resource', function () {
    $visit = PageVisitFactory::new()->create();

    expect(PageVisitResource::canCreate())->toBeFalse()
        ->and(PageVisitResource::canEdit($visit))->toBeFalse()
        ->and(PageVisitResource::canDelete($visit))->toBeFalse()
        ->and(PageVisitResource::canDeleteAny())->toBeFalse();
});

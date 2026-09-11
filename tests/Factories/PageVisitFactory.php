<?php

namespace JeffersonGoncalves\Filament\PageVisits\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JeffersonGoncalves\LaravelPageVisits\Models\PageVisit;

/**
 * @extends Factory<PageVisit>
 */
class PageVisitFactory extends Factory
{
    protected $model = PageVisit::class;

    public function definition(): array
    {
        return [
            'visited_at' => now(),
            'path' => '/'.fake()->slug(),
            'route_name' => fake()->optional()->word(),
            'method' => 'GET',
            'status_code' => 200,
            'device_type' => fake()->randomElement(['desktop', 'mobile', 'tablet']),
            'browser' => fake()->randomElement(['Chrome', 'Firefox', 'Safari']),
            'browser_version' => (string) fake()->numberBetween(100, 130),
            'operating_system' => fake()->randomElement(['Windows', 'macOS', 'Linux']),
            'operating_system_version' => (string) fake()->numberBetween(10, 15),
            'country' => fake()->country(),
            'country_code' => fake()->countryCode(),
            'referer_type' => fake()->randomElement(['direct', 'social', 'search']),
            'is_bot' => false,
            'is_vpn' => false,
            'is_proxy' => false,
            'is_tor' => false,
            'is_datacenter' => false,
        ];
    }
}

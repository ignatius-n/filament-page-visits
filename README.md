# Filament Page Visits

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-page-visits.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-page-visits)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-page-visits/tests.yml?branch=3.x&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/filament-page-visits/actions?query=workflow%3ATests+branch%3A3.x)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-page-visits/pint.yml?branch=3.x&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/filament-page-visits/actions?query=workflow%3A%22Fix+PHP+code+styling%22+branch%3A3.x)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-page-visits.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-page-visits)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/filament-page-visits.svg?style=flat-square)](LICENSE.md)

A read-only Filament admin resource for
[`jeffersongoncalves/laravel-page-visits`](https://github.com/jeffersongoncalves/laravel-page-visits) — the
headless core package that tracks page-view visits on your app's public routes (device, browser, geo, locale,
referer, UTM). This package owns no models, migrations or tracking logic of its own: it is purely the
presentation layer (a Resource, Pages, widgets) built on top of the core's `PageVisit` model.

## Compatibility

| `filament-page-visits` | `laravel-page-visits` | Filament |
| --- | --- | --- |
| [1.x](https://github.com/jeffersongoncalves/filament-page-visits/tree/1.x) | `^1.0` | v3 |
| [2.x](https://github.com/jeffersongoncalves/filament-page-visits/tree/2.x) | `^1.0` | v4 |
| [3.x](https://github.com/jeffersongoncalves/filament-page-visits/tree/3.x) | `^1.0` | v5 |

> `laravel-page-visits` requires Laravel 12 or 13 (`illuminate/contracts: ^12.0|^13.0`) on every branch — see the
> note below if a given Filament major doesn't hold up against that floor in practice.

## What's included

- **`PageVisitResource`** — a browsable, filterable list of tracked visits (date/time, path, method, status
  code, device, browser, OS, country, referer type, bot flag), with a detail view grouped into Request, Device,
  Location, Referer & UTM, Bot/Risk flags and Fingerprint sections. The resource is intentionally read-only
  (no create, edit or delete) — visits are an append-only audit log written by the core package.
- **`StatsOverview`** — total visits, visits today, bot %, top country.
- **`HourlyChart`** — visits per hour for the last 24h.
- pt_BR and en translations.

This plugin has **no config file of its own** — table name, tracked fields, excluded paths and retention are all
configured on `laravel-page-visits`' own `config/page-visits.php` (see that package's README).

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/filament-page-visits:"^3.0"
```

This pulls in `jeffersongoncalves/laravel-page-visits` (`^1.0`) as a dependency. Publish and run its migration
per that package's own installation instructions, then register the plugin in your PanelProvider:

```php
use JeffersonGoncalves\Filament\PageVisits\FilamentPageVisitsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FilamentPageVisitsPlugin::make(),
        ]);
}
```

## Testing

```bash
composer test        # Pest
composer analyse      # PHPStan (Larastan)
composer format        # Pint
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

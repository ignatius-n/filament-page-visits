<?php

return [
    'metrics_page' => [
        // Filament defaults an unset slug to Str::kebab(class basename) —
        // "metrics-page" for any package's MetricsPage class. Explicit here
        // so this doesn't collide with another plugin's own MetricsPage at
        // the same URL in a host panel that installs both (confirmed:
        // jeffersongoncalves/filament-short-url ships an identically-named
        // page — this package deliberately mirrors its pattern).
        'slug' => 'page-visits-metrics',
    ],
];

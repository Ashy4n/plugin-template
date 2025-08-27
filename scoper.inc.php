<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    'prefix' => 'Template\\Vendor',
    'finders' => [
        Finder::create()->files()->in('vendor')->name(['*.php', '*.json', '*.md']),
    ],
    'exclude-namespaces' => [
        'Template',
        'Ashy4n',
    ],
    'exclude-classes' => [
        'WP_*',
        'WP_*',
    ],
    'exclude-functions' => [
        'wp_*',
        'add_*',
        'remove_*',
        'get_*',
        'is_*',
        'has_*',
        'do_*',
        'apply_*',
        'esc_*',
        'sanitize_*',
        'wp_*',
    ],
    'exclude-constants' => [
        'WP_*',
        'ABSPATH',
        'WP_*',
    ],
    'expose-global-constants' => false,
    'expose-global-classes' => false,
    'expose-global-functions' => false,
];

<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'SafeKeep'),
        'short_name' => 'SafeKeep',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [

            '750x750' => [
                'path' => '/images/icons/icon-750x750.png',
                'purpose' => 'any'
            ],
            '500x500' => [
                'path' => '/images/icons/icon-500x500.png',
                'purpose' => 'any'
            ],

            '250x250' => [
                'path' => '/images/icons/icon-250x250.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [

            '828x1792' => '/images/icons/splash-828x1792.png',

        ],
        'shortcuts' => [
            [
                'name' => 'DashBoard',
                'description' => 'A Dashboard of your secrets',
                'url' => '/dashboard',
                'icons' => [
                    "src" => "https://s2.svgbox.net/octicons.svg?ic=home&color=000",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Add Secrets',
                'description' => 'Add your deep secrets',
                'url' => '/word/create',
                'icons' => [
                    "src" => "https://s2.svgbox.net/hero-outline.svg?ic=plus-circle&color=000",
                    "purpose" => "any"
                ]
            ]
        ],
        'custom' => []
    ]
];

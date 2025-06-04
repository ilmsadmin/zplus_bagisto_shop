<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ViPOS Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the ViPOS package.
    |
    */

    'receipt' => [
        'store_name' => env('VIPOS_STORE_NAME', 'My Store'),
        'store_address' => env('VIPOS_STORE_ADDRESS', ''),
        'store_phone' => env('VIPOS_STORE_PHONE', ''),
        'thank_you_message' => env('VIPOS_THANK_YOU_MESSAGE', 'Thank you for your purchase!'),
        'footer_text' => env('VIPOS_FOOTER_TEXT', ''),
    ],

    'tax' => [
        'default_rate' => env('VIPOS_DEFAULT_TAX_RATE', 0.0),
        'calculation_method' => env('VIPOS_TAX_CALCULATION_METHOD', 'exclusive'),
    ],

    'payment_methods' => [
        'cash' => [
            'enabled' => true,
            'denominations' => [1, 5, 10, 20, 50, 100, 500, 1000],
        ],
        'card' => [
            'enabled' => true,
        ],
        'upi' => [
            'enabled' => true,
        ],
        'bank_transfer' => [
            'enabled' => true,
        ],
    ],

    'display' => [
        'products_per_page' => 20,
        'categories_per_row' => 6,
        'theme_color' => '#3B82F6',
    ],
];
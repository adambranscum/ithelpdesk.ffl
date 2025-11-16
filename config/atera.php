<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Atera API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Atera API integration
    |
    */

    'api_key' => env('ATERA_API_KEY'),
    
    'api_url' => env('ATERA_API_URL', 'https://app.atera.com/api/v3'),
    
    'receipt_email' => env('ATERA_RECEIPT_EMAIL'),
];
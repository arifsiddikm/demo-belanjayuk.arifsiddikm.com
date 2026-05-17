<?php
return [
    'name' => env('APP_NAME', 'BelanjaYuk!'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),
    'locale' => env('APP_LOCALE', 'id'),
    'fallback_locale' => 'en',
    'faker_locale' => 'id_ID',
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => array_filter(explode(',', env('APP_PREVIOUS_KEYS', ''))),
    'maintenance' => ['driver' => 'file'],
    'order_prefix' => env('MIDTRANS_ORDER_PREFIX', 'INV'),
    'admin_email' => env('ADMIN_EMAIL', 'admin@belanjayuk.com'),
];

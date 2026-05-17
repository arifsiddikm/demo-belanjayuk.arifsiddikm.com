<?php
return [
    'midtrans' => [
        'client_key' => env('MIDTRANS_CLIENT_KEY'),
        'server_key' => env('MIDTRANS_SERVER_KEY'),
        'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
        'snap_js_url' => env('MIDTRANS_SNAP_JS_URL', 'https://app.sandbox.midtrans.com/snap/snap.js'),
        'riplabs_key' => env('RIPLABS_KEY'),
        'riplabs_snaptoken_url' => env('RIPLABS_SNAPTOKEN_URL'),
        'callback_key' => env('MIDTRANS_CALLBACK_KEY'),
    ],
    'rajaongkir' => [
        'api_key' => env('RAJAONGKIR_API_KEY'),
        'base_url' => env('RAJAONGKIR_BASE_URL', 'https://rajaongkir.komerce.id/api/v1'),
    ],
];

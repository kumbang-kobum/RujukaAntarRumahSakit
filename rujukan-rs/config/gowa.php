<?php

return [
    'base_url' => env('GOWA_BASE_URL', 'http://127.0.0.1:3000'),
    'token' => env('GOWA_TOKEN', null),
    'timeout' => (int) env('GOWA_TIMEOUT', 10),
];
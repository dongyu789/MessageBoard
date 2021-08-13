<?php

return [
    "https" => [
        'http' => env('ELASTIC_SEARCH_HOST'),
        'port' => env('ELASTIC_SEARCH_PORT'),
        'scheme' => env('ELASTIC_SEARCH_SCHEME')
    ]
];
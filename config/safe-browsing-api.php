<?php

return [
    'key' => env('SAFE_BROWSING_API_KEY'),
    'api_url' => env('SAFE_BROWSING_API_URL', 'https://safebrowsing.googleapis.com/v4/threatMatches:find'),
    'data' => [
        'client' => [
            'clientId' => env('SAFE_BROWSING_API_CLIENT'),
            'clientVersion' => '1.5.2',
        ],
        'threatInfo' => [
            'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
            'platformTypes' => ['ANY_PLATFORM'],
            'threatEntryTypes' => ['URL'],
            'threatEntries' => [],
        ],
    ],
];

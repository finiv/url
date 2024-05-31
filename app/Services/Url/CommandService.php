<?php

namespace App\Services\Url;

use App\Helpers\UrlHelper;
use App\Models\Url;
use Illuminate\Support\Str;

class CommandService
{
    public function createUrl(string $url): Url
    {
        $parsedUrl = UrlHelper::getUrlParts($url);
        $dataToCreate = ['scheme' => $parsedUrl['scheme'], 'original_url' => $url, 'host' => $parsedUrl['host']];

        if (isset($parsedUrl['ending']) && $parsedUrl['ending']) {
            $hash = Str::random(6);

            while (Url::where('hash', $hash)->exists()) {
                $hash = Str::random(6);
            }
            $dataToCreate['hash'] = "/$hash";
            $dataToCreate['route_ending'] = $parsedUrl['ending'];
        }

        return Url::create($dataToCreate); // could be cached
    }
}

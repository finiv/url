<?php

namespace App\Services\Url;

use App\Models\Url;

class QueryService
{
    public function getUrl(string $url): Url
    {
        if ($existingUrl = Url::where('original_url', $url)->first()) {
            return $existingUrl;
        }

        return app(CommandService::class)->createUrl($url);
    }
}

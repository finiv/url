<?php

namespace App\Services\Url;

use App\Helpers\UrlHelper;
use App\Models\Url;

class QueryService
{
    public function shortUrl(string $url): Url
    {
        if ($existingUrl = Url::where('original_url', $url)->first()) {
            return $existingUrl;
        }

        return app(CommandService::class)->createUrl($url);
    }
    public function getUrl(string $url): string
    {
        $urlParts = UrlHelper::getUrlParts($url);

        if ($existingUrl = Url::where('original_url', $url)->orWhere('hash', $urlParts['ending'])->first()) {
            return $existingUrl->original_url;
        }

        return '/';
    }
}

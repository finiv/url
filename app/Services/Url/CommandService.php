<?php

namespace App\Services\Url;

use App\Models\Url;

class CommandService
{
    public function createUrl(string $url): Url
    {
        return $url = Url::create([
            'original_url' => $url,
            'short_url' => substr(md5($url), 0, 6),
        ]);
    }
}

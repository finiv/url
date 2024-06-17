<?php

namespace App\Services\SafeBrowsing;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleSafeBrowsingAPI
{
    public function isValid(string $url): bool
    {
        if (Cache::get('unsafe_urls') && in_array($url, Cache::get('unsafe_urls'))) {
            return false;
        }

        try {
            $result = $this->send(
                $this->makeApiUrl(),
                $this->makeData($url),
                $this->makeMethod()
            );

            if (isset($result['matches'])) {
                $this->cacheUrl($url);

                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::info(now().'Something went wrong: '.$e->getMessage());

            return false;
        }
    }

    private function send(string $apiUrl, array $data, string $method)
    {
        $client = new Client;

        $response = $client->$method($apiUrl, [
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    private function makeMethod(): string
    {
        return 'POST';
    }

    private function makeApiUrl(): string
    {
        return config('safe-browsing-api.api_url')."?key=".config('safe-browsing-api.key');
    }

    private function makeData(string $url): array
    {
        $data = config('safe-browsing-api.data');
        $data['threatInfo']['threatEntries'] = ['url' => $url];

        return $data;
    }

    private function cacheUrl(string $url): void
    {
        $unsafeUrls = Cache::get('unsafe_urls', []);

        if (!in_array($url, $unsafeUrls)) {
            $unsafeUrls[] = $url;
        }

        Cache::put('unsafe_urls', $unsafeUrls, now()->addHours(2));
    }
}

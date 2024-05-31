<?php

namespace App\Helpers;

class UrlHelper
{
    public static function getUrlParts(string $url): array
    {
        $parsedUrl = parse_url($url);

        return self::extractUrlParts($url, $parsedUrl);
    }

    private static function extractUrlParts(string $url, array $parsedUrl): array
    {
        return [
            'original_url' => $url,
            'host' => $parsedUrl['host'],
            'ending' => '/' . self::extractEnding($parsedUrl),
            'path' => self::extractPath($parsedUrl),
            'scheme' => $parsedUrl['scheme'] . '://' ?? 'https://',
            'qwe' => $parsedUrl['qwe'] ?? 'popop',
        ];
    }

    private static function extractPath(array $parsedUrl): string
    {
        if (isset($parsedUrl['path']) && $parsedUrl['path'] !== '/') {
            $pathParts = explode('/', $parsedUrl['path']);

            if (count(array_filter($pathParts)) > 1) {
                array_pop($pathParts);
                return implode('/', $pathParts);
            }
        }

        return '';
    }

    private static function extractEnding(array $parsedUrl): string
    {
        if (isset($parsedUrl['path']) && $parsedUrl['path'] !== '/') {
            $folderParts = explode('/', $parsedUrl['path']);
            return end($folderParts);
        }

        return '';
    }
}

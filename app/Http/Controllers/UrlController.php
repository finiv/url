<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Http\Resources\UrlResource;
use App\Services\SafeBrowsing\GoogleSafeBrowsingAPI;
use App\Services\Url\QueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UrlController extends Controller
{
    public function __construct(private readonly QueryService $service, private readonly GoogleSafeBrowsingAPI $googleSafeBrowsingAPI) {}

    public function shortUrl(UrlRequest $request): JsonResponse
    {
        if ($this->googleSafeBrowsingAPI->isValid($url = $request->get('url'))) {
            return response()->json(
                ['url' => UrlResource::make($this->service->shortUrl($url))]
            );
        }

        return response()->json(['error' => 'Something went wrong'], 400);
    }

    public function redirect($any): RedirectResponse
    {
        return redirect($this->service->getUrl($any));
    }
}

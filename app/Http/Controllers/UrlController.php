<?php

namespace App\Http\Controllers;

use App\Services\Url\QueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function __construct(private readonly QueryService $service) {}

    public function shortUrl(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        return response()->json(
            ['url' => $this->service->getUrl($request->get('url'))]
        );
    }
}

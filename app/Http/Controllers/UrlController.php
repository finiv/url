<?php

namespace App\Http\Controllers;

use App\Http\Resources\UrlResource;
use App\Services\Url\QueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function __construct(private readonly QueryService $service) {}

    public function shortUrl(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url'
        ]); // or could be in form request

        return response()->json(
            ['url' => UrlResource::make($this->service->shortUrl($request->get('url')))]
        );
    }

    public function redirect($any): RedirectResponse
    {
        return redirect($this->service->getUrl($any));
    }
}

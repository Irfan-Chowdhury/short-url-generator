<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ShortUrlService;
use Illuminate\Http\Request;

final class ShortUrlController
{
    public $shortService;

    public function __construct(ShortUrlService $shortUrlService)
    {
        $this->shortService = $shortUrlService;
    }

    public function home()
    {
        return view('pages.home');
    }

    public function shorten(Request $request)
    {
        $request->validate(['original_url' => 'required|url']);

        $shortUrl = $this->shortService->generateShortUrl($request->original_url);

        return redirect()->back()->with('shortUrl', $shortUrl);
    }

    public function redirect(string $shortCode)
    {
        $getOriginalUrl = $this->shortService->getOriginalUrl($shortCode);

        return redirect($getOriginalUrl);
    }

    public function allUrlList()
    {
        $urlData = $this->shortService->getAll();

        return view('pages.all-url-list', compact('urlData'));
    }
}

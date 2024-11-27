<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

final class ShortUrlController
{
    public function home()
    {
        return view('home');
    }

    public function shorten(Request $request)
    {
        $request->validate(['original_url' => 'required|url']);

        $shortCode = self::generateUniqueCode();

        ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode
        ]);

        return redirect()->back()->with('shortUrl', url($shortCode));
    }

    public function redirect(string $shortCode)
    {
        $data = ShortUrl::query()
                ->where('short_code',$shortCode)
                ->firstOrFail();

        $data->increment('click_count');

        return redirect($data->original_url);
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }


}

<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

final class ShortUrlService
{
    public function generateShortUrl(string $originalURL): string
    {
        $getExistingShortURL = self::existsOriginalUrl($originalURL);

        if ($getExistingShortURL) {
            return url($getExistingShortURL->short_code);
        }

        return self::getNewShortUrl($originalURL);
    }

    public function existsOriginalUrl(string $originalURL): ?object
    {
        $query = ShortUrl::query()
            ->select('short_code')
            ->where('original_url', $originalURL);

        if ($query->exists()) {
            return $query->firstOrFail();
        }

        return null;
    }

    public function getNewShortUrl(string $originalURL): string
    {
        $shortCode = self::generateUniqueCode();

        ShortUrl::create([
            'original_url' => $originalURL,
            'short_code' => $shortCode,
        ]);

        return url($shortCode);
    }

    public function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }

    public function getOriginalUrl(string $shortCode): string
    {
        $data = ShortUrl::query()
            ->where('short_code', $shortCode)
            ->firstOrFail();

        $data->increment('click_count');

        return $data->original_url;
    }

    public function getAll()
    {
        $data = ShortUrl::select('id', 'original_url', 'short_code', 'click_count', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($item) {
                return [
                    'original_url' => $item->original_url,
                    'short_url' => url($item->short_code),
                    'click_count' => $item->click_count,
                    'created' => $item->created_at->format('d F, Y'),
                ];
            });

        return json_decode(json_encode($data), false);
    }
}

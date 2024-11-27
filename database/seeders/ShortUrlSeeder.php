<?php

namespace Database\Seeders;

use App\Models\ShortUrl;
use Illuminate\Database\Seeder;

class ShortUrlSeeder extends Seeder
{
    public function run(): void
    {
        ShortUrl::factory()
        ->count(50)
        ->create();
    }
}

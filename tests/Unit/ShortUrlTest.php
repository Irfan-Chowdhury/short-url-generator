<?php

use App\Models\ShortUrl;
use App\Services\ShortUrlService;
use Illuminate\Support\Str;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class); // Reset the database after each test

beforeEach(function () {
    $this->shortUrlService = new ShortUrlService();
});


test('Exist original url', function () {
    // $this->withoutExceptionHandling();

    $url = 'https://example.com';

    ShortUrl::create([
        'original_url' => $url,
        'short_code' => 'ABC',
        'click_count' => 0,
    ]);

    $getdata = $this->shortUrlService->existsOriginalUrl($url);

    expect($getdata)->toBeObject();
});


test('Does not exist original url', function () {
    $url = 'https://pestphp.com/docs/expectations#expect-toBeObject';
    $getdata = $this->shortUrlService->existsOriginalUrl($url);

    expect($getdata)->toBeNull();
});

test('Generate new short Url', function () {
    $url = 'https://www.thedailystar.net/sports/football/news/fifa-launches-2022-world-cup-legacy-fund-initiatives-who-wto-and-unhcr-3763066';
    $getdata = $this->shortUrlService->generateShortUrl($url);

    expect($getdata)->toBeString();
});


test('ShortCode return a string type', function () {
    $getShortCode = $this->shortUrlService->generateUniqueCode();

    expect($getShortCode)->toBeString();
});


test('ShortCode parameter Type must be a string', function () {

    $shortCode = 'ABC123';

    ShortUrl::factory()->create([
        'short_code' => $shortCode,
        'original_url' => 'https://pestphp.com/',
        'click_count' => 0,
    ]);

    $getOriginalUrl = $this->shortUrlService->getOriginalUrl($shortCode);

    expect($shortCode)->toBeString();
    expect($getOriginalUrl)->toBe('https://pestphp.com/');
});


test('ShortCode length is : 6', function () {
    $getShortCode = $this->shortUrlService->generateUniqueCode();
    $lengthOfCode = strlen($getShortCode);

    expect($lengthOfCode)->toBe(6);
});



test('Short URL is unique', function () {

    $fakeUrl = 'https://abc.com';
    $shortCode = Str::random(6);

    ShortUrl::create([
        'original_url' => $fakeUrl,
        'short_code' => $shortCode,
        'click_count' => 0,
    ]);

    $makeShortURL = $fakeUrl.'/'.$shortCode;


    $getNewCode = $this->shortUrlService->generateUniqueCode();  // This method
    $getNewShortURL = $fakeUrl.'/'.$getNewCode;

    // Assert that the new generated url not same. This is unique
    expect($makeShortURL)->not->toBe($getNewShortURL);
});



test('Get All Short URLs Data', function () {
    $getData = $this->shortUrlService->getAll();

    expect($getData)->toBeArray();
});

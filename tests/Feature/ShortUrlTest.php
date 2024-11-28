<?php

it('Home Page Load', function () {

    $response = $this->get('/');

    $response->assertStatus(200);
});


test('Home page Http Check', function () {

    $response = $this->get('/');
    $this->get(route('home'))->assertOk();
    $response->assertStatus(200);
});


test('Home page correct view', function() {
    $this->get(route('home'))
        ->assertOk()
        ->assertViewIs('pages.home');
});


// Validation

test('require the original_url', function () {
    // $this->withoutExceptionHandling();
    $this->post(route('shorten'), ['original_url' => null])
        ->assertInvalid(['original_url' => 'required']);
});

test('Invalid long url', function () {
    $this->post(route('shorten'), ['original_url' => 'this is wrong'])
    ->assertSessionHasErrors('original_url');
});

/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
|
*/

test('Store valid long url | keep value in a session', function () {
    $response = $this->post(route('shorten'), [
        'original_url' => 'https://www.thedailystar.net/sports/cricket/news/tigresses-register-their-biggest-win-wodis-3762916'
    ]);

    $response->assertRedirect();

    $this->assertNotNull(session('shortUrl'));
});

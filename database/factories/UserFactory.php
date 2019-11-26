<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use OpenTok\OpenTok;
use OpenTok\MediaMode;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $otApi = new OpenTok(config('app.opentok_api_key'), config('app.opentok_api_secret'));
    $session = $otApi->createSession(['mediaMode' => MediaMode::ROUTED]);
    return [
        'name' => $faker->name,
        'username' => $faker->username,
        'session_id' => $session->getSessionId(),
        'remember_token' => Str::random(10),
    ];
});

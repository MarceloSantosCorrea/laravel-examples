<?php

use App\Models\User;
use function Pest\Laravel\postJson;

test('deve retornar um erro de senha incorreta ao efetuar login', function () {
    $user = User::factory()->create();
    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password_error',
        'device_name' => 'device_test'
    ])
        ->assertUnprocessable()
        ->assertJson(['message' => 'The provided credentials are incorrect.']);
});

test('deve efetuar login e retornar um token', function () {
    $user = User::factory()->create();
    postJson('api/login', [
        'email' => $user->email,
        'password' => 'password',
        'device_name' => 'device_test'
    ])
        ->assertOk()
        ->assertJsonStructure(['token']);
});

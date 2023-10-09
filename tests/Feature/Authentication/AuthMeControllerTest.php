<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

test('deve retornar os dados do usuário logado', function () {
    $response = actingAs(User::factory()->create())
        ->getJson('api/user')
        ->assertOk();
//        ->assertJson(['message' => 'The provided credentials are incorrect.']);
});



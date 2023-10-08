<?php

use App\Models\User;
use function Pest\Laravel\{actingAs, postJson};

test('deve retornar não autenticado ao criar uma tarefa', function () {
    postJson('api/todos')
        ->assertUnauthorized();
});

test('deve retornar erro de validação ao criar uma tarefa', function () {
    actingAs(User::factory()->create())
        ->postJson('api/todos', [])
        ->assertUnprocessable()
        ->assertInvalid([
            'body',
        ]);

    actingAs(User::factory()->create())
        ->postJson('api/todos', [
            'body' => 'Tarefa',
            'checked' => 'valor diferente de booleano'
        ])
        ->assertUnprocessable()
        ->assertInvalid([
            'checked',
        ]);
});

test('deve criar uma tarefa', function () {
    $user = User::factory()->create();
    $body = fake()->sentence(5);
    actingAs($user)->postJson('api/todos', [
        'body' => $body,
        'checked' => false
    ])
        ->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'checked',
                'created_at',
                'updated_at'
            ]
        ]);
});

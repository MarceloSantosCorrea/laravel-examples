<?php

use App\Models\Todo;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\putJson;

test('deve retornar não autenticado ao atualizar uma tarefa', function () {
    putJson('api/todos/fake_id')
        ->assertUnauthorized();
});

test('deve retornar erro de validação ao atualizar uma tarefa', function () {
    $todo = Todo::factory()->create();
    actingAs(User::factory()->create())
        ->putJson("api/todos/{$todo->id}", [])
        ->assertUnprocessable()
        ->assertInvalid([
            'body',
        ]);

    actingAs(User::factory()->create())
        ->putJson("api/todos/{$todo->id}", [
            'body' => 'Tarefa',
            'checked' => 'valor diferente de booleano'
        ])
        ->assertUnprocessable()
        ->assertInvalid([
            'checked',
        ]);
});

test('deve atualizar uma tarefa', function () {
    $user = User::factory()->create();
    $todo = Todo::factory()->create([
        'checked' => false
    ])->refresh();
    $response = actingAs($user)->putJson("api/todos/{$todo->id}", [
        'body' => 'Tarefa alterada',
        'checked' => true
    ])
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'checked',
                'created_at',
                'updated_at'
            ]
        ]);

    $todo->refresh();

    expect($response['data']['id'])->toEqual($todo->id)
        ->and($response['data']['body'])->toEqual('Tarefa alterada')
        ->and($response['data']['checked'])->toBeTrue($todo->checked)
        ->and($response['data']['created_at'])->toEqual((string)$todo->created_at)
        ->and($response['data']['updated_at'])->toEqual((string)$todo->updated_at);
});

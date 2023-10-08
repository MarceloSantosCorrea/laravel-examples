<?php

use App\Models\Todo;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('deve retornar não autenticado ao exibir uma tarefa', function () {
    getJson('api/todos/fake_id')
        ->assertUnauthorized();
});

test('deve exibir uma tarefa', function () {
    $user = User::factory()->create();

    $todo = Todo::factory()->create()->refresh();
    $response = actingAs($user)->getJson("api/todos/{$todo->id}")
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'checked',
                'created_at',
                'updated_at'
            ],
        ]);

    expect($response['data']['id'])->toEqual($todo->id)
        ->and($response['data']['body'])->toEqual($todo->body)
        ->and($response['data']['checked'])->toEqual($todo->checked)
        ->and($response['data']['created_at'])->toEqual((string)$todo->created_at)
        ->and($response['data']['updated_at'])->toEqual((string)$todo->updated_at);
});

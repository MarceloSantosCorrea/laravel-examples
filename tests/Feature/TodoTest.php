<?php

use App\Models\Todo;
use App\Models\User;
use function Pest\Laravel\actingAs;

test('deve listar tarefas com paginação', function () {
    $user = User::factory()->create();

    Todo::factory(20)->create();
    $response = actingAs($user)->getJson('api/todos')
        ->assertOk()
        ->assertJsonCount(15, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'body',
                    'checked',
                    'created_at',
                    'updated_at'
                ]
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total'
            ],
        ]);

    expect($response['meta']['current_page'])->toEqual(1)
        ->and($response['meta']['from'])->toEqual(1)
        ->and($response['meta']['last_page'])->toEqual(2)
        ->and($response['meta']['links'])->toEqual([
            ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
            ['url' => 'http://localhost/api/todos?page=1', 'label' => "1", 'active' => true],
            ['url' => 'http://localhost/api/todos?page=2', 'label' => "2", 'active' => false],
            ['url' => 'http://localhost/api/todos?page=2', 'label' => 'Next &raquo;', 'active' => false]
        ])
        ->and($response['meta']['path'])->toEqual('http://localhost/api/todos')
        ->and($response['meta']['per_page'])->toEqual(15)
        ->and($response['meta']['to'])->toEqual(15)
        ->and($response['meta']['total'])->toEqual(20);
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

test('deve deletar uma tarefa', function () {
    $user = User::factory()->create();
    $todo = Todo::factory()->create();
    actingAs($user)->deleteJson("api/todos/{$todo->id}")
        ->assertNoContent();

    expect(Todo::count())->toEqual(0);
});

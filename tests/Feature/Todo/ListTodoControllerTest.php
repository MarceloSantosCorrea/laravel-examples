<?php

use App\Models\Todo;
use App\Models\User;
use function Pest\Laravel\{actingAs, getJson};

test('deve retornar não autenticado ao listar uma tarefa', function () {
    getJson('api/todos')
        ->assertUnauthorized();
});

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

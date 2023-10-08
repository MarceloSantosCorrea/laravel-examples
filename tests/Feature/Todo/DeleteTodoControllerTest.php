<?php

use App\Models\Todo;
use App\Models\User;
use function Pest\Laravel\{actingAs, deleteJson};

test('deve retornar não autenticado ao deletar uma tarefa', function () {
    deleteJson('api/todos/fake_id')
        ->assertUnauthorized();
});

test('deve deletar uma tarefa', function () {
    $user = User::factory()->create();
    $todo = Todo::factory()->create();
    actingAs($user)->deleteJson("api/todos/{$todo->id}")
        ->assertNoContent();

    expect(Todo::count())->toEqual(0);
});

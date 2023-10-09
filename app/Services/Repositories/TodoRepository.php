<?php

namespace App\Services\Repositories;

use Core\Todo\Application\Repository\TodoRepositoryInterface;
use Core\Todo\Domain\Entity\Todo;
use Exception;

class TodoRepository implements TodoRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function insert(Todo $todo): Todo
    {
        $model = \App\Models\Todo::create([
            'id' => $todo->id(),
            'body' => $todo->body,
            'checked' => $todo->checked,
            'created_at' => $todo->createdAt(),
            'updated_at' => $todo->updatedAt(),
        ]);

        return static::toTodo($model);
    }

    /**
     * @throws Exception
     */
    public static function toTodo(\App\Models\Todo $todo): Todo
    {
        return Todo::buildExistingTodo(
            id: $todo->id,
            body: $todo->body,
            checked: $todo->checked,
            createdAt: $todo->created_at,
            updatedAt: $todo->updated_at
        );
    }
}

<?php

namespace App\Services\Repositories;

use App\Models\Todo as Model;
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
        $model = Model::create([
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
    public static function toTodo(Model $todo): Todo
    {
        return Todo::buildExistingTodo(
            id: $todo->id,
            body: $todo->body,
            checked: $todo->checked,
            createdAt: $todo->created_at,
            updatedAt: $todo->updated_at
        );
    }

    /**
     * @throws Exception
     */
    public function findById(string $id): ?Todo
    {
        $model = Model::find($id);

        if (!$model) return null;

        return static::toTodo($model);
    }

    /**
     * @throws Exception
     */
    public function update(Todo $todo): Todo
    {
        /** @var Model $model */
        $model = Model::find($todo->id);

        $model->update([
            'body' => $todo->body,
            'checked' => $todo->checked,
            'updated_at' => $todo->updatedAt(),
        ]);

        return static::toTodo($model);
    }
}

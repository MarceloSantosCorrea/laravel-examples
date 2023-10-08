<?php

namespace App\Http\Controllers\Api\Todo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Todo\StoreTodoRequest;
use App\Http\Resources\Api\Todo\ShowTodoResource;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @tags Todos
 */
class StoreTodoController extends Controller
{
    /**
     * @response ShowTodoResource
     * @operationId Create
     */
    public function __invoke(StoreTodoRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $todo = Todo::create($validated)->refresh();

        return (new ShowTodoResource($todo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}

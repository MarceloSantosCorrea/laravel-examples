<?php

namespace App\Http\Controllers\Api\Todo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Todo\StoreTodoRequest;
use App\Http\Resources\Api\Todo\ShowTodoResource;
use App\Models\Todo;
use Illuminate\Http\Response;

/**
 * @tags Todos
 */
class UpdateTodoController extends Controller
{
    /**
     * @response ShowTodoResource
     * @operationId Update
     */
    public function __invoke(StoreTodoRequest $request, Todo $todo): ShowTodoResource
    {
        $validated = $request->validated();
        $todo->update($validated);

        return new ShowTodoResource($todo);
    }
}

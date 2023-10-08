<?php

namespace App\Http\Controllers\Api\Todo;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @tags Todos
 */
class DeleteTodoController extends Controller
{
    /**
     * @operationId Delete
     */
    public function __invoke(Todo $todo): JsonResponse
    {
        $todo->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

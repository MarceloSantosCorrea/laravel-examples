<?php

namespace App\Http\Controllers\Api\Todo;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Todo\ShowTodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;

/**
 * @tags Todos
 */
class ShowTodoController extends Controller
{
    /**
     * @operationId Show
     */
    public function __invoke(Request $request, Todo $todo): ShowTodoResource
    {
        return new ShowTodoResource($todo);
    }
}

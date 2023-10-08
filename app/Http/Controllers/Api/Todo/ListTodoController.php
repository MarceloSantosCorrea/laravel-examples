<?php

namespace App\Http\Controllers\Api\Todo;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Todo\ShowTodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Todos
 */
class ListTodoController extends Controller
{
    /**
     * @operationId List
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $todos = Todo::paginate();

        return ShowTodoResource::collection($todos);
    }
}

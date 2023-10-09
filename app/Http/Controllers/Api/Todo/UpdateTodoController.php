<?php

namespace App\Http\Controllers\Api\Todo;

use App\Core\Todo\Application\UseCase\UpdateTodoUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Todo\StoreTodoRequest;
use App\Http\Resources\Api\Todo\ShowTodoResource;
use App\Models\Todo;
use Core\Todo\Application\UseCase\DTO\UpdateTodoInputDto;
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
    public function __invoke(
        StoreTodoRequest  $request,
        UpdateTodoUseCase $useCase,
        Todo              $todo
    ): ShowTodoResource
    {
        $response = $useCase->execute(
            new UpdateTodoInputDto(
                id: $todo->id,
                body: $request->input('body'),
                checked: $request->input('checked')
            )
        );

        return new ShowTodoResource($response);
    }
}

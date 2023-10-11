<?php

namespace App\Http\Controllers\Api\Todo;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Todo\ShowTodoResource;
use App\Models\Todo;
use Core\Todo\Application\UseCase\DTO\ShowTodoInputDto;
use Core\Todo\Application\UseCase\ShowTodoUseCase;
use Illuminate\Http\Request;

/**
 * @tags Todos
 */
class ShowTodoController extends Controller
{
    /**
     * @operationId Show
     */
    public function __invoke(ShowTodoUseCase $useCase, Todo $todo): ShowTodoResource
    {
        $response = $useCase->execute(
            new ShowTodoInputDto(
                id: $todo->id
            )
        );
        return new ShowTodoResource($response);
    }
}

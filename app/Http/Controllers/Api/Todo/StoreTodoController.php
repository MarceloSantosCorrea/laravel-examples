<?php

namespace App\Http\Controllers\Api\Todo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Todo\StoreTodoRequest;
use App\Http\Resources\Api\Todo\ShowTodoResource;
use Core\Todo\Application\UseCase\CreateTodoUseCase;
use Core\Todo\Application\UseCase\DTO\CreateTodoInputDto;
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
    public function __invoke(
        StoreTodoRequest  $request,
        CreateTodoUseCase $useCase
    ): JsonResponse
    {
        $response = $useCase->execute(
            new CreateTodoInputDto(
                body: $request->input('body'),
                checked: $request->input('checked'),
            )
        );

        return (new ShowTodoResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Core\Todo\Application\UseCase\CreateTodoUseCase;
use Core\Todo\Application\UseCase\DTO\CreateTodoInputDto;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareParams
{
    public function __construct(private CreateTodoUseCase $useCase)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->useCase->execute(
            new CreateTodoInputDto(
                body: 'Tarefa ' . date('H:i:s'),
                checked: false,
            )
        );

        return $next($request);
    }
}

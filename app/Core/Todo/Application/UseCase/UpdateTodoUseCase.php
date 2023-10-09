<?php

namespace App\Core\Todo\Application\UseCase;

use Core\Todo\Application\Repository\TodoRepositoryInterface;
use Core\Todo\Application\UseCase\DTO\TodoOutputDto;
use Core\Todo\Application\UseCase\DTO\UpdateTodoInputDto;

readonly class UpdateTodoUseCase
{
    public function __construct(
        private TodoRepositoryInterface $todoRepository
    )
    {
    }

    public function execute(UpdateTodoInputDto $input): TodoOutputDto
    {
        $todo = $this->todoRepository->findById($input->id);

        $todo->update(
            body: $input->body,
            checked: $input->checked,
        );

        $response = $this->todoRepository->update($todo);

        return new TodoOutputDto(
            id: $response->id(),
            body: $response->body,
            checked: $response->checked,
            created_at: $response->createdAt(),
            updated_at: $response->updatedAt()
        );
    }
}

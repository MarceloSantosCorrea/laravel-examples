<?php

namespace Core\Todo\Application\UseCase;

use Core\Todo\Application\Repository\TodoRepositoryInterface;
use Core\Todo\Application\UseCase\DTO\ShowTodoInputDto;
use Core\Todo\Application\UseCase\DTO\TodoOutputDto;

readonly class ShowTodoUseCase
{
    public function __construct(
        private TodoRepositoryInterface $todoRepository
    ) {
    }

    public function execute(ShowTodoInputDto $input): TodoOutputDto
    {
        $todo = $this->todoRepository->findById($input->id);

        return new TodoOutputDto(
            id: $todo->id(),
            body: $todo->body,
            checked: $todo->checked,
            created_at: $todo->createdAt(),
            updated_at: $todo->updatedAt()
        );
    }
}

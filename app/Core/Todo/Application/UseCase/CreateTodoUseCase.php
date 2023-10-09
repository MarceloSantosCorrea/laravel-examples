<?php

namespace Core\Todo\Application\UseCase;

use Core\Todo\Application\Repository\TodoRepositoryInterface;
use Core\Todo\Application\UseCase\DTO\CreateTodoInputDto;
use Core\Todo\Application\UseCase\DTO\TodoOutputDto;
use Core\Todo\Domain\Entity\Todo;

readonly class CreateTodoUseCase
{
    public function __construct(
        private TodoRepositoryInterface $todoRepository
    )
    {
    }

    public function execute(CreateTodoInputDto $input): TodoOutputDto
    {
        $todo = $this->todoRepository->insert(
            Todo::new(
                body: $input->body,
                checked: $input->checked
            )
        );

        return new TodoOutputDto(
            id: $todo->id(),
            body: $todo->body,
            checked: $todo->checked,
            created_at: $todo->createdAt(),
            updated_at: $todo->updatedAt()
        );
    }
}

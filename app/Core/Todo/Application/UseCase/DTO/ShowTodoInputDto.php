<?php

namespace Core\Todo\Application\UseCase\DTO;

class ShowTodoInputDto
{
    public function __construct(
        public string $id
    ) {
    }
}

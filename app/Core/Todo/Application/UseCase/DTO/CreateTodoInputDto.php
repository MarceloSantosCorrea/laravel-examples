<?php

namespace Core\Todo\Application\UseCase\DTO;

class CreateTodoInputDto
{
    public function __construct(
        public string $body,
        public bool   $checked,
    )
    {
    }
}

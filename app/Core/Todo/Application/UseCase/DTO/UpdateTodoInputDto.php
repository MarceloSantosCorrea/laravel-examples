<?php

namespace Core\Todo\Application\UseCase\DTO;

class UpdateTodoInputDto
{
    public function __construct(
        public string $id,
        public string $body,
        public bool   $checked,
    )
    {
    }
}

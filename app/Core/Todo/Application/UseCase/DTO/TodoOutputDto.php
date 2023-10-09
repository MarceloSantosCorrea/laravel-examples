<?php

namespace Core\Todo\Application\UseCase\DTO;

class TodoOutputDto
{
    public function __construct(
        public string $id,
        public string $body,
        public bool   $checked,
        public string $created_at,
        public string $updated_at,
    )
    {
    }
}

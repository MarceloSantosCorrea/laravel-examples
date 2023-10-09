<?php

namespace Core\Shared\Domain\Entity\Traits;

trait HasCreatedAt
{
    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}

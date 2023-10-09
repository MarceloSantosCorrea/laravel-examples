<?php

namespace Core\Shared\Domain\Entity\Traits;

trait HasUpdateAt
{
    public function updatedAt(): string
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }
}

<?php

namespace Core\Shared\Domain\Entity\Traits;

trait HasId
{
    public function id(): string
    {
        return (string) $this->id;
    }
}

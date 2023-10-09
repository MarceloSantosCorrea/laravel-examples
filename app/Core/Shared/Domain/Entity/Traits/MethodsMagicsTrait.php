<?php

namespace Core\Shared\Domain\Entity\Traits;

trait MethodsMagicsTrait
{
    public function __get($property)
    {
        return $this->{$property};
    }
}

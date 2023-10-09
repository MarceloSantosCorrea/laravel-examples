<?php

namespace Core\Todo\Application\Repository;

use Core\Todo\Domain\Entity\Todo;

interface TodoRepositoryInterface
{
    public function insert(Todo $todo): Todo;

    public function findById(string $id): ?Todo;

    public function update(Todo $todo): Todo;
}

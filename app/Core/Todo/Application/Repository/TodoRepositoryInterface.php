<?php

namespace Core\Todo\Application\Repository;

use Core\Todo\Domain\Entity\Todo;

interface TodoRepositoryInterface
{
    public function insert(Todo $todo): Todo;
}

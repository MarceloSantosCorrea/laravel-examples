<?php

namespace Core\Todo\Domain\Entity;

use Core\Shared\Domain\Entity\Traits\HasCreatedAt;
use Core\Shared\Domain\Entity\Traits\HasId;
use Core\Shared\Domain\Entity\Traits\HasUpdateAt;
use Core\Shared\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Shared\Domain\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;
use Exception;

/**
 * @property-read string id
 * @property-read string body
 * @property-read bool checked
 * @property-read DateTimeInterface createdAt
 * @property-read DateTimeInterface updatedAt
 */
class Todo
{
    use MethodsMagicsTrait;
    use HasId;
    use HasCreatedAt;
    use HasUpdateAt;

    private function __construct(
        protected Uuid              $id,
        protected string            $body,
        protected bool              $checked,
        protected DateTimeInterface $createdAt,
        protected DateTimeInterface $updatedAt,
    )
    {
    }

    public static function new(
        string $body,
        bool   $checked,
    ): static
    {
        return new static(
            id: Uuid::random(),
            body: $body,
            checked: $checked,
            createdAt: new DateTime(),
            updatedAt: new DateTime(),
        );
    }

    /**
     * @throws Exception
     */
    public static function buildExistingTodo(
        string $id,
        string $body,
        bool   $checked,
        string $createdAt,
        string $updatedAt,
    ): static
    {
        return new static(
            id: new Uuid($id),
            body: $body,
            checked: $checked,
            createdAt: new DateTime($createdAt),
            updatedAt: new DateTime($updatedAt),
        );
    }

    public function update(
        string $body,
        bool   $checked,
    ): void
    {
        $this->body = $body;
        $this->checked = $checked;

        $this->updatedAt = new DateTime();
    }
}

<?php

namespace Core\Shared\Domain\ValueObject;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(protected string $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (!RamseyUuid::isValid($this->value)) {
            throw new InvalidArgumentException(
                sprintf(
                    '<%s> does not allow the value <%s>',
                    static::class,
                    $this->value,
                )
            );
        }
    }

    public static function random(): self
    {
        return new self(Str::orderedUuid());
    }

    public function __toString()
    {
        return $this->value;
    }
}

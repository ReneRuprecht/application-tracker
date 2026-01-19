<?php

namespace App\Domain\ValueObject;

use Symfony\Component\Uid\UuidV4;

final class JobApplicationId
{
    private function __construct(private string $value)
    {
    }

    public static function generate(): self
    {
        return new self(UuidV4::v4()->toString());
    }

    public static function fromString(string $value): self
    {
        if (!UuidV4::isValid($value)) {
            throw new \InvalidArgumentException('Invalid JobApplicationId');
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value == $other->value;
    }
}

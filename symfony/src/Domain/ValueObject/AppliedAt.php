<?php

namespace App\Domain\ValueObject;

final class AppliedAt
{
    public function __construct(private \DateTimeImmutable $value)
    {
        if ($value > new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('AppliedAt cannot be in the future');
        }
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }
}

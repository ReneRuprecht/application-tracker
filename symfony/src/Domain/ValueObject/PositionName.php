<?php

namespace App\Domain\ValueObject;

final class PositionName
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if ('' == $value) {
            throw new \InvalidArgumentException('Position name cannot be empty');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}

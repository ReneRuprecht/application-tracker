<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

final class PositionName
{
  private string $value;

  public function __construct(string $value)
  {
    $value = trim($value);

    if ($value == '') {
      throw new InvalidArgumentException("Position name cannot be empty");
    }

    $this->value = $value;
  }

  public function value()
  {
    return $this->value;
  }
}

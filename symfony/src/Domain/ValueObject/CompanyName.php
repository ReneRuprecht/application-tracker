<?php

namespace App\Domain\ValueObject;

use InvalidArgumentException;

final class CompanyName
{
  private String $value;

  public function __construct(string $value)
  {
    $value = trim($value);

    if ($value == '') {
      throw new InvalidArgumentException("Company name cannot be empty");
    }

    $this->value = $value;
  }

  public function value(): string
  {
    return $this->value;
  }

  public function __toString()
  {
    return $this->value;
  }
}

<?php

namespace App\Application\Command;

use DateTimeImmutable;

final class CreateJobApplicationCommand
{
  public function __construct(
    public readonly string $company,
    public readonly string $position,
    public readonly DateTimeImmutable $appliedAt
  ) {}
}

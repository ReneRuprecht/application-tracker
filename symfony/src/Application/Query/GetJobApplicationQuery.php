<?php

namespace App\Application\Query;

final class GetJobApplicationQuery
{
  public function __construct(
    public readonly string $id
  ) {}
}

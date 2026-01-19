<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\AppliedAt;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class AppliedAtTest extends TestCase
{

  public function test_it_accepts_past_date(): void
  {
    $date = new DateTimeImmutable('-1 day');
    $appliedAt = new AppliedAt($date);

    $this->assertSame($date, $appliedAt->value());
  }

  public function test_it_rejects_future_date(): void
  {
    $this->expectException(InvalidArgumentException::class);

    new AppliedAt(new DateTimeImmutable('+1 day'));
  }
}

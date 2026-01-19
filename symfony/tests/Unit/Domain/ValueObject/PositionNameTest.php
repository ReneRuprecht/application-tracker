<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\PositionName;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PositionNameTest extends TestCase
{
  public function test_it_can_be_created(): void
  {
    $position = new PositionName('Developer');

    $this->assertSame('Developer', $position->value());
  }

  public function test_it_cannot_be_empty(): void
  {
    $this->expectException(InvalidArgumentException::class);

    new PositionName(' ');
  }
}

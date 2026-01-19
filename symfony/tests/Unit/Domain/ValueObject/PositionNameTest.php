<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\PositionName;
use PHPUnit\Framework\TestCase;

final class PositionNameTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $position = new PositionName('Developer');

        $this->assertSame('Developer', $position->value());
    }

    public function testItCannotBeEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new PositionName(' ');
    }
}

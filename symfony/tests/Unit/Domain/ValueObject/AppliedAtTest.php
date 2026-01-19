<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\AppliedAt;
use PHPUnit\Framework\TestCase;

final class AppliedAtTest extends TestCase
{
    public function testItAcceptsPastDate(): void
    {
        $date = new \DateTimeImmutable('-1 day');
        $appliedAt = new AppliedAt($date);

        $this->assertSame($date, $appliedAt->value());
    }

    public function testItRejectsFutureDate(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new AppliedAt(new \DateTimeImmutable('+1 day'));
    }
}

<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\CompanyName;
use PHPUnit\Framework\TestCase;

final class CompanyNameTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $company = new CompanyName('test company');

        $this->assertSame('test company', $company->value());
    }

    public function testItTrimsWhitespace(): void
    {
        $company = new CompanyName('  test company  ');

        $this->assertSame('test company', $company->value());
    }

    public function testItCannotBeEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new CompanyName('');
    }

    public function testItCanBeCastToString(): void
    {
        $company = new CompanyName('test company');

        $this->assertSame('test company', (string) $company);
    }
}

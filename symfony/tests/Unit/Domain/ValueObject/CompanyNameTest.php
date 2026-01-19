<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\CompanyName;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CompanyNameTest extends TestCase
{
  public function test_it_can_be_created(): void
  {
    $company = new CompanyName('test company');

    $this->assertSame('test company', $company->value());
  }
  public function test_it_trims_whitespace(): void
  {
    $company = new CompanyName('  test company  ');

    $this->assertSame('test company', $company->value());
  }

  public function test_it_cannot_be_empty(): void
  {
    $this->expectException(InvalidArgumentException::class);

    new CompanyName('');
  }

  public function test_it_can_be_cast_to_string(): void
  {
    $company = new CompanyName('test company');

    $this->assertSame('test company', (string)$company);
  }
}

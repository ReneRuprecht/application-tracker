<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\JobApplication;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\JobApplicationId;
use App\Domain\ValueObject\PositionName;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV4;

final class JobApplicationTest extends TestCase
{

  public function test_it_can_be_created(): void
  {
    $company = new CompanyName('test company');
    $position = new PositionName('Developer');
    $appliedAt = new AppliedAt(new DateTimeImmutable('-1 day'));


    $application = JobApplication::create($company, $position, $appliedAt);

    $this->assertSame($company, $application->company());
    $this->assertSame($position, $application->position());
    $this->assertSame($appliedAt, $application->appliedAt());
  }

  public function test_it_can_return_valid_uuid(): void
  {
    $company = new CompanyName('test company');
    $position = new PositionName('Developer');
    $appliedAt = new AppliedAt(new DateTimeImmutable('-1 day'));


    $application = JobApplication::create($company, $position, $appliedAt);

    $this->assertTrue(UuidV4::isValid($application->id()->value()));
  }
}

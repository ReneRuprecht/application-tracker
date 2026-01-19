<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\JobApplication;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\JobApplicationId;
use App\Domain\ValueObject\PositionName;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV4;

final class JobApplicationTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $company = new CompanyName('test company');
        $position = new PositionName('Developer');
        $appliedAt = new AppliedAt(new \DateTimeImmutable('-1 day'));

        $application = JobApplication::create($company, $position, $appliedAt);

        $this->assertSame($company, $application->company());
        $this->assertSame($position, $application->position());
        $this->assertSame($appliedAt, $application->appliedAt());
    }

    public function testItCanBeRecreated(): void
    {
        $id = JobApplicationId::fromString('cb0aef80-c421-4f37-8b72-0d1c9a7fe177');
        $company = new CompanyName('test company');
        $position = new PositionName('Developer');
        $appliedAt = new AppliedAt(new \DateTimeImmutable('-1 day'));

        $application = JobApplication::recreate($id, $company, $position, $appliedAt);

        $this->assertSame($id, $application->id());
        $this->assertSame($company, $application->company());
        $this->assertSame($position, $application->position());
        $this->assertSame($appliedAt, $application->appliedAt());
    }

    public function testItCanReturnValidUuid(): void
    {
        $company = new CompanyName('test company');
        $position = new PositionName('Developer');
        $appliedAt = new AppliedAt(new \DateTimeImmutable('-1 day'));

        $application = JobApplication::create($company, $position, $appliedAt);

        $this->assertTrue(UuidV4::isValid($application->id()->value()));
    }
}

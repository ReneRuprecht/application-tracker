<?php

namespace App\Tests\Unit\Application\Handler;

use App\Application\Handler\ListJobApplicationHandler;
use App\Domain\Entity\JobApplication;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\PositionName;
use App\Infrastructure\DB\InMemoryJobApplicationRepository;
use PHPUnit\Framework\TestCase;

final class ListJobApplicationHandlerTest extends TestCase
{
    public function testItReturnsAllJobApplications(): void
    {
        $repo = new InMemoryJobApplicationRepository();

        $date = new \DateTimeImmutable();

        $application1 = JobApplication::create(
            new CompanyName('1'),
            new PositionName('A'),
            new AppliedAt($date)
        );
        $application2 = JobApplication::create(
            new CompanyName('2'),
            new PositionName('B'),
            new AppliedAt($date)
        );

        $repo->save($application1);
        $repo->save($application2);

        $handler = new ListJobApplicationHandler($repo);

        $applications = $handler();

        $this->assertCount(2, $applications);
        $this->assertSame('1', $application1->company()->value());
        $this->assertSame('A', $application1->position()->value());
        $this->assertSame($date, $application1->appliedAt()->value());
        $this->assertNotNull($application1->id());

        $this->assertSame('2', $application2->company()->value());
        $this->assertSame('B', $application2->position()->value());
        $this->assertSame($date, $application2->appliedAt()->value());
        $this->assertNotNull($application2->id());
    }

    public function testItReturnsEmptyArrayIfNoApplications(): void
    {
        $repo = new InMemoryJobApplicationRepository();
        $handler = new ListJobApplicationHandler($repo);

        $all = $handler();

        $this->assertSame([], $all);
    }
}

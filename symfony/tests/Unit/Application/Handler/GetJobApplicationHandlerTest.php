<?php

namespace App\Tests\Unit\Application\Handler;

use App\Application\Handler\GetJobApplicationHandler;
use App\Application\Query\GetJobApplicationQuery;
use App\Domain\Entity\JobApplication;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\JobApplicationId;
use App\Domain\ValueObject\PositionName;
use App\Infrastructure\DB\InMemoryJobApplicationRepository;
use PHPUnit\Framework\TestCase;

final class GetJobApplicationHandlerTest extends TestCase
{
    public function testItReturnsJobApplicationIfExists(): void
    {
        $repo = new InMemoryJobApplicationRepository();

        $date = new \DateTimeImmutable();

        $application = JobApplication::create(
            new CompanyName('test company'),
            new PositionName('dev'),
            new AppliedAt($date)
        );
        $repo->save($application);

        $handler = new GetJobApplicationHandler($repo);
        $query = new GetJobApplicationQuery($application->id()->value());

        $result = $handler($query);

        $this->assertNotNull($result);
        $this->assertSame('test company', $result->company()->value());
        $this->assertSame('dev', $result->position()->value());
        $this->assertSame($date, $result->appliedAt()->value());
        $this->assertNotSame('', $result->id()->value());
    }

    public function testItReturnsNullIfNotFound(): void
    {
        $repo = new InMemoryJobApplicationRepository();
        $handler = new GetJobApplicationHandler($repo);

        $query = new GetJobApplicationQuery(JobApplicationId::generate()->value());
        $result = $handler($query);

        $this->assertNull($result);
    }
}

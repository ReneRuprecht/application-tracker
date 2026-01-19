<?php

namespace App\Tests\Unit\Application\Handler;

use App\Application\Command\CreateJobApplicationCommand;
use App\Application\Handler\CreateJobApplicationHandler;
use App\Infrastructure\DB\InMemoryJobApplicationRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class CreateJobApplicationHandlerTest extends TestCase
{
  public function test_it_saves_job_application()
  {
    $repo = new InMemoryJobApplicationRepository();
    $handler = new CreateJobApplicationHandler($repo);

    $date = new DateTimeImmutable(('2025-01-01'));

    $command = new CreateJobApplicationCommand(
      company: 'test company',
      position: 'dev',
      appliedAt: $date
    );
    $handler($command);

    $jobApplications = $repo->findAll();
    $this->assertCount(1, $jobApplications);

    $application = $jobApplications[0];

    $this->assertNotNull($application->id());
    $this->assertsame('test company', $application->company()->value());
    $this->assertsame('dev', $application->position()->value());
    $this->assertsame($date, $application->appliedAt()->value());
  }
}

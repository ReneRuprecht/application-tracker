<?php

namespace App\Application\Handler;

use App\Application\Command\CreateJobApplicationCommand;
use App\Domain\Entity\JobApplication;
use App\Domain\Repository\JobApplicationRepositoryInterface;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\PositionName;

final class CreateJobApplicationHandler
{
  public function __construct(private JobApplicationRepositoryInterface $repositoy) {}
  public function __invoke(CreateJobApplicationCommand $command): string
  {
    $jobApplication = JobApplication::create(
      new CompanyName($command->company),
      new PositionName($command->position),
      new AppliedAt($command->appliedAt)
    );

    $this->repositoy->save($jobApplication);

    return $jobApplication->id()->value();
  }
}

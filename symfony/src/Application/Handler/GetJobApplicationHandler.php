<?php

namespace App\Application\Handler;

use App\Application\Query\GetJobApplicationQuery;
use App\Domain\Repository\JobApplicationRepositoryInterface;
use App\Domain\ValueObject\JobApplicationId;

final class GetJobApplicationHandler
{

  public function __construct(private JobApplicationRepositoryInterface $repository) {}

  public function __invoke(GetJobApplicationQuery $query): ?array
  {
    $jobApplication = $this->repository->findById(
      JobApplicationId::fromString($query->id)
    );

    if ($jobApplication == null) {
      return null;
    }

    return [
      'id' => $jobApplication->id()->value(),
      'company' => $jobApplication->company()->value(),
      'position' => $jobApplication->position()->value(),
      'appliedAt' => $jobApplication->appliedAt()->value()->format("d-m-Y")
    ];
  }
}

<?php

namespace App\Application\Handler;

use App\Domain\Repository\JobApplicationRepositoryInterface;

final class ListJobApplicationHandler
{

  public function __construct(private JobApplicationRepositoryInterface $repository) {}

  public function __invoke(): array
  {
    $result = [];

    foreach ($this->repository->findAll() as $jobApplication) {
      $result[] = [
        'id' => $jobApplication->id()->value(),
        'company' => $jobApplication->company()->value(),
        'position' => $jobApplication->position()->value(),
        'appliedAt' => $jobApplication->appliedAt()->value()->format("d-m-Y")
      ];
    }

    return $result;
  }
}

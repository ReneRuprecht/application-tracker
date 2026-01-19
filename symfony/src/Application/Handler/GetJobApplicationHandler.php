<?php

namespace App\Application\Handler;

use App\Application\Query\GetJobApplicationQuery;
use App\Domain\Entity\JobApplication;
use App\Domain\Repository\JobApplicationRepositoryInterface;
use App\Domain\ValueObject\JobApplicationId;

final class GetJobApplicationHandler
{
    public function __construct(private JobApplicationRepositoryInterface $repository)
    {
    }

    public function __invoke(GetJobApplicationQuery $query): ?JobApplication
    {
        $jobApplication = $this->repository->findById(
            JobApplicationId::fromString($query->id)
        );

        if (null == $jobApplication) {
            return null;
        }

        return JobApplication::recreate(
            $jobApplication->id(),
            $jobApplication->company(),
            $jobApplication->position(),
            $jobApplication->appliedAt()
        );
    }
}

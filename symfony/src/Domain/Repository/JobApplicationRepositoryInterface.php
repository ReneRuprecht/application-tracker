<?php

namespace App\Domain\Repository;

use App\Domain\Entity\JobApplication;
use App\Domain\ValueObject\JobApplicationId;

interface JobApplicationRepositoryInterface
{
    public function save(JobApplication $jobApplication): void;

    public function findById(JobApplicationId $id): ?JobApplication;

    /** @return JobApplication[] */
    public function findAll(): array;
}

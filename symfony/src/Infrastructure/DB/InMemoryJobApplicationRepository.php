<?php

namespace App\Infrastructure\DB;

use App\Domain\Entity\JobApplication;
use App\Domain\Repository\JobApplicationRepositoryInterface;
use App\Domain\ValueObject\JobApplicationId;

final class InMemoryJobApplicationRepository implements JobApplicationRepositoryInterface
{
    /** @var array<string, JobApplication> */
    private array $storage = [];

    public function save(JobApplication $jobApplication): void
    {
        $this->storage[$jobApplication->id()->value()] = $jobApplication;
    }

    public function findById(JobApplicationId $id): ?JobApplication
    {
        return $this->storage[$id->value()] ?? null;
    }

    public function findAll(): array
    {
        return array_values($this->storage);
    }
}

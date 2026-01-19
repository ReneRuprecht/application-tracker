<?php

namespace App\Infrastructure\DB;

use App\Domain\Entity\JobApplication;
use App\Domain\Repository\JobApplicationRepositoryInterface;
use App\Domain\ValueObject\JobApplicationId;
use App\Infrastructure\Doctrine\JobApplicationOrm;
use App\Infrastructure\JobApplicationMapper;
use Doctrine\ORM\EntityManagerInterface;

final class PostgresJobApplicationRepository implements JobApplicationRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function save(JobApplication $domain): void
    {
        $orm = JobApplicationMapper::toOrm($domain);
        $this->em->persist($orm);
        $this->em->flush();
    }

    public function findById(JobApplicationId $id): ?JobApplication
    {
        $orm = $this->em->find(JobApplicationOrm::class, (string) $id->value());

        return $orm ? JobApplicationMapper::toDomain($orm) : null;
    }

    public function findAll(): array
    {
        $orms = $this->em
          ->getRepository(JobApplicationOrm::class)
          ->findAll();

        return array_map(
            fn (JobApplicationOrm $orm) => JobApplicationMapper::toDomain($orm),
            $orms
        );
    }
}

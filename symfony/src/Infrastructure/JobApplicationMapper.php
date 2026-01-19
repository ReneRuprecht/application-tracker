<?php

namespace App\Infrastructure;

use App\Domain\Entity\JobApplication;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\JobApplicationId;
use App\Domain\ValueObject\PositionName;
use App\Infrastructure\Doctrine\JobApplicationOrm;

final class JobApplicationMapper
{
  public static function toOrm(JobApplication $domain): JobApplicationOrm
  {
    $orm = new JobApplicationOrm();
    $orm->id = (string) $domain->id()->value();
    $orm->company = $domain->company()->value();
    $orm->position = $domain->position()->value();
    $orm->appliedAt = $domain->appliedAt()->value();

    return $orm;
  }

  public static function toDomain(JobApplicationOrm $orm): JobApplication
  {
    $domain = JobApplication::recreate(
      JobApplicationId::fromString($orm->id),
      new CompanyName($orm->company),
      new PositionName($orm->position),
      new AppliedAt($orm->appliedAt)
    );

    return $domain;
  }
}

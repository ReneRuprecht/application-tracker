<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\PositionName;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\JobApplicationId;

final class JobApplication
{
  private function __construct(private JobApplicationId $id, private CompanyName $comanpy, private PositionName $position, private AppliedAt $appliedAt) {}

  public static function create(CompanyName $comanpy, PositionName $position, AppliedAt $appliedAt): self
  {
    return new self(
      JobApplicationId::generate(),
      $comanpy,
      $position,
      $appliedAt
    );
  }

  public function id(): JobApplicationId
  {
    return $this->id;
  }
  public function company(): CompanyName
  {
    return $this->comanpy;
  }
  public function position(): PositionName
  {
    return $this->position;
  }
  public function appliedAt(): AppliedAt
  {
    return $this->appliedAt;
  }
}

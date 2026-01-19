<?php

namespace App\Infrastructure\Doctrine;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'job_applications')]
final class JobApplicationOrm
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public string $id;

    #[ORM\Column]
    public string $company;

    #[ORM\Column]
    public string $position;

    #[ORM\Column(type: 'datetime_immutable')]
    public \DateTimeImmutable $appliedAt;
}

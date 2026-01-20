<?php

namespace App\Tests\Integration\Infrastructure\DB;

use App\Domain\Entity\JobApplication;
use App\Domain\ValueObject\AppliedAt;
use App\Domain\ValueObject\CompanyName;
use App\Domain\ValueObject\JobApplicationId;
use App\Domain\ValueObject\PositionName;
use App\Infrastructure\DB\PostgresJobApplicationRepository;
use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

final class PostgresJobApplicationRepositoryTest extends TestCase
{
    private EntityManagerInterface $em;
    private PostgresJobApplicationRepository $repository;

    protected function setUp(): void
    {
        $kernel = new Kernel('test', true);
        $kernel->boot();

        /** @var ManagerRegistry $doctrine */
        $doctrine = $kernel->getContainer()->get('doctrine');

        /** @var EntityManagerInterface $em */
        $em = $doctrine->getManager();
        $this->em = $em;

        $this->repository = new PostgresJobApplicationRepository($this->em);

        $this->cleanUp();
    }

    private function cleanUp(): void
    {
        $connection = $this->em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('job_applications', true));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->em->close();
        unset($this->em);
    }

    public function testItSavesJobApplication(): void
    {
        $date = new \DateTimeImmutable('2025-01-01');
        $application = JobApplication::create(new CompanyName('test company'), new PositionName('dev'), new AppliedAt($date));

        $this->repository->save($application);

        $fetched = $this->repository->findById($application->id());

        $this->assertNotNull($fetched);
        $this->assertSame('test company', $fetched->company()->value());
        $this->assertSame('dev', $fetched->position()->value());
        $this->assertSame($date, $fetched->appliedAt()->value());
    }

    public function testItReturnsJobApplicationByIdIfPresent(): void
    {
        $date = new \DateTimeImmutable('2025-01-01');
        $application = JobApplication::create(new CompanyName('test company'), new PositionName('dev'), new AppliedAt($date));

        $this->repository->save($application);

        $fetched = $this->repository->findById($application->id());

        $this->assertNotNull($fetched);
        $this->assertNotSame('', $fetched->id()->value());
        $this->assertSame('test company', $fetched->company()->value());
        $this->assertSame('dev', $fetched->position()->value());
        $this->assertSame($date, $fetched->appliedAt()->value());
    }

    public function testItReturnsNullIfIdNotPresent(): void
    {
        $id = JobApplicationId::fromString('cb0aef80-c421-4f37-8b72-0d1c9a7fe177');

        $fetched = $this->repository->findById($id);

        $this->assertNull($fetched);
    }

    public function testItReturnsAllJobApplicationsIfPresent(): void
    {
        $date = new \DateTimeImmutable('2025-01-01');

        $application1 = JobApplication::create(new CompanyName('test company'), new PositionName('dev'), new AppliedAt($date));
        $application2 = JobApplication::create(new CompanyName('test company2'), new PositionName('fullstack'), new AppliedAt($date));

        $this->repository->save($application1);
        $this->repository->save($application2);

        $all = $this->repository->findAll();

        $this->assertCount(2, $all);
    }
}

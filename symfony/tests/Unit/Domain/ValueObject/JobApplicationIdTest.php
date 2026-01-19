<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\JobApplicationId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV4;

final class JobApplicationIdTest extends TestCase
{
  public function test_it_can_be_created_with_valid_uuid(): void
  {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $id = JobApplicationId::fromString($uuid);

    $this->assertSame($uuid, $id->value());
  }

  public function test_it_throws_exception_for_invalid_uuid(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Invalid JobApplicationId');

    JobApplicationId::fromString('invalid-id');
  }

  public function test_it_can_generate_valid_uuid(): void
  {
    $id = JobApplicationId::generate();

    $this->assertTrue(UuidV4::isValid($id->value()));
  }

  public function test_it_is_equal(): void
  {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $id = JobApplicationId::fromString($uuid);
    $id_two = JobApplicationId::fromString($uuid);

    $this->assertTrue($id->equals($id_two));
  }
  public function test_it_not_equal(): void
  {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $id = JobApplicationId::fromString($uuid);
    $id_two = JobApplicationId::generate();

    $this->assertFalse($id->equals($id_two));
  }
}

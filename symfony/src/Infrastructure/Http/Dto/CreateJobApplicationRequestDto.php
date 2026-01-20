<?php

namespace App\Infrastructure\Http\Dto;

final class CreateJobApplicationRequestDto
{
    public function __construct(
        public string $company,
        public string $position,
        public \DateTimeImmutable $appliedAt,
    ) {
    }

    /**
     * @param array{company: string, position: string, appliedAt: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['company'],
            $data['position'],
            new \DateTimeImmutable($data['appliedAt'])
        );
    }
}

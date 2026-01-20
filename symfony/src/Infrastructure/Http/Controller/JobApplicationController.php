<?php

namespace App\Infrastructure\Http\Controller;

use App\Application\Command\CreateJobApplicationCommand;
use App\Application\Handler\CreateJobApplicationHandler;
use App\Application\Handler\GetJobApplicationHandler;
use App\Application\Handler\ListJobApplicationHandler;
use App\Application\Query\GetJobApplicationQuery;
use App\Infrastructure\Http\Dto\CreateJobApplicationRequestDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/job-applications')]
final class JobApplicationController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function create(Request $request, CreateJobApplicationHandler $handler): JsonResponse
    {
        $data = $request->toArray();

        /** @var array{company: string, position: string, appliedAt: string} $data */
        $dto = CreateJobApplicationRequestDto::fromArray($data);

        $command = new CreateJobApplicationCommand(
            company: $dto->company,
            position: $dto->position,
            appliedAt: $dto->appliedAt
        );

        $id = $handler($command);

        return new JsonResponse(
            [
                'id' => $id,
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    #[Route('', methods: ['GET'])]
    public function list(ListJobApplicationHandler $handler): JsonResponse
    {
        $result = $handler();

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(string $id, GetJobApplicationHandler $handler): JsonResponse
    {
        $result = $handler(new GetJobApplicationQuery($id));

        if (null == $result) {
            return new JsonResponse(['error' => 'Not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($result);
    }
}

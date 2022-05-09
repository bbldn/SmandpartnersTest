<?php

namespace App\Domain\Main\Infrastructure\Controller;

use Throwable;
use BBLDN\CQRSBundle\QueryBus\QueryBus;
use BBLDN\CQRSBundle\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Domain\Main\Application\Query\CommentList;
use App\Domain\Common\Domain\Exception\RestException;
use App\Domain\Common\Domain\Exception\ValidateException;
use App\Domain\Main\Application\Command\RemoveCommentById;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use App\Domain\Main\Domain\Entity\Input\CreateOrUpdateComment;
use App\Domain\Main\Domain\Request\CreateOrUpdateCommentRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\Common\Application\ExceptionFormatter\Formatter as ExceptionFormatter;
use App\Domain\Common\Application\EntityToArrayHydrator\Hydrator as EntityToArrayHydrator;
use App\Domain\Main\Application\Command\CreateOrUpdateComment as CreateOrUpdateCommentCommand;
use App\Domain\Common\Application\ArrayToEntityHydrator\HydratorWithValidator as ArrayToEntityHydrator;

class MainController extends AbstractController
{
    /**
     * @param QueryBus $queryBus
     * @param ExceptionFormatter $exceptionFormatter
     * @param EntityToArrayHydrator $entityToArrayHydrator
     * @return JsonResponse
     */
    #[Route(path: "/comments", methods: "GET")]
    public function commentList(
        QueryBus $queryBus,
        ExceptionFormatter $exceptionFormatter,
        EntityToArrayHydrator $entityToArrayHydrator
    ): JsonResponse
    {
        $query = new CommentList();
        $commentList = $queryBus->execute($query);

        try {
            $data = $entityToArrayHydrator->hydrateArray($commentList);
        } catch (RestException $e) {
            return $this->json($exceptionFormatter->format($e));
        }

        return $this->json(['data' => $data]);
    }

    /**
     * @param string $id
     * @param CommandBus $commandBus
     * @param ExceptionFormatter $exceptionFormatter
     * @return JsonResponse
     */
    #[Route(path: "/comment/{id}", methods: "DELETE", requirements: ['id' => '\d+'])]
    public function removeCommentById(
        string $id,
        CommandBus $commandBus,
        ExceptionFormatter $exceptionFormatter
    ): JsonResponse
    {
        $command = new RemoveCommentById((int)$id);

        try {
            $data = $commandBus->execute($command);
        } catch (Throwable $e) {
            return $this->json($exceptionFormatter->format($e));
        }

        return $this->json(['data' => $data]);
    }

    /**
     * @param Request $request
     * @param CommandBus $commandBus
     * @param ExceptionFormatter $exceptionFormatter
     * @param ArrayToEntityHydrator $arrayToEntityHydrator
     * @param EntityToArrayHydrator $entityToArrayHydrator
     * @return JsonResponse
     */
    #[Route(path: "/comment", methods: ["PUT", "POST"])]
    public function createOrUpdateComment(
        Request $request,
        CommandBus $commandBus,
        ExceptionFormatter $exceptionFormatter,
        ArrayToEntityHydrator $arrayToEntityHydrator,
        EntityToArrayHydrator $entityToArrayHydrator
    ): JsonResponse
    {
        try {
            $requestData = $request->toArray();
        } catch (JsonException $e) {
            return $this->json($exceptionFormatter->format($e));
        }

        /** @var CreateOrUpdateCommentRequest $dto */
        try {
            $dto = $arrayToEntityHydrator->hydrateEntity($requestData, CreateOrUpdateCommentRequest::class);
        } catch (RestException|ValidateException $e) {
            return $this->json($exceptionFormatter->format($e));
        }

        /** @var CreateOrUpdateComment $mutation */
        $mutation = $dto->getInput();

        try {
            $comment = $commandBus->execute(new CreateOrUpdateCommentCommand($mutation));
            $data = $entityToArrayHydrator->hydrateEntity($comment);
        } catch (Throwable $e) {
            return $this->json($exceptionFormatter->format($e));
        }

        return $this->json(['data' => $data]);
    }
}
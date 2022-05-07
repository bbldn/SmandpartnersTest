<?php

namespace App\Domain\Main\Infrastructure\Controller;

use BBLDN\CQRSBundle\QueryBus\QueryBus;
use BBLDN\CQRSBundle\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Domain\Main\Application\Query\CommentList;
use App\Domain\Main\Application\Command\RemoveCommentById;
use App\Domain\Main\Application\Command\CreateOrUpdateComment as CreateOrUpdateCommentCommand;
use App\Domain\Main\Domain\Request\CreateOrUpdateCommentRequest;
use App\Domain\Main\Domain\Entity\Input\CreateOrUpdateComment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\Common\Application\EntityToArrayHydrator\Hydrator as EntityToArrayHydrator;
use App\Domain\Common\Application\ArrayToEntityHydrator\Hydrator as ArrayToEntityHydrator;

class MainController extends AbstractController
{
    /**
     * @param QueryBus $queryBus
     * @param EntityToArrayHydrator $entityToArrayHydrator
     * @return JsonResponse
     */
    #[Route(path: "/comments", methods: "GET")]
    public function commentList(
        QueryBus $queryBus,
        EntityToArrayHydrator $entityToArrayHydrator
    ): JsonResponse
    {
        $query = new CommentList();
        $commentList = $queryBus->execute($query);

        return $this->json([
            'data' => $entityToArrayHydrator->hydrateArray($commentList),
        ]);
    }

    /**
     * @param string $id
     * @param CommandBus $commandBus
     * @return JsonResponse
     */
    #[Route(path: "/comment/{id}", methods: "DELETE", requirements: ['id' => '\d+'])]
    public function removeCommentById(
        string $id,
        CommandBus $commandBus
    ): JsonResponse
    {
        $command = new RemoveCommentById((int)$id);

        return $this->json([
            'data' => $commandBus->execute($command),
        ]);
    }

    /**
     * @param Request $request
     * @param CommandBus $commandBus
     * @param ArrayToEntityHydrator $arrayToEntityHydrator
     * @param EntityToArrayHydrator $entityToArrayHydrator
     * @return JsonResponse
     */
    #[Route(path: "/comment", methods: ["PUT", "POST"])]
    public function createOrUpdateComment(
        Request $request,
        CommandBus $commandBus,
        ArrayToEntityHydrator $arrayToEntityHydrator,
        EntityToArrayHydrator $entityToArrayHydrator
    ): JsonResponse
    {
        /** @var CreateOrUpdateCommentRequest $dto */
        $dto = $arrayToEntityHydrator->hydrateEntity($request->toArray(), CreateOrUpdateCommentRequest::class);

        /** @var CreateOrUpdateComment  $mutation */
        $mutation = $dto->getInput();

        $comment = $commandBus->execute(new CreateOrUpdateCommentCommand($mutation));

        return $this->json([
            'data' => $entityToArrayHydrator->hydrateEntity($comment),
        ]);
    }
}
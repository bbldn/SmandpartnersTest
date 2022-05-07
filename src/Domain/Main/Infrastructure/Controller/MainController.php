<?php

namespace App\Domain\Main\Infrastructure\Controller;

use BBLDN\CQRSBundle\QueryBus\QueryBus;
use BBLDN\CQRSBundle\CommandBus\CommandBus;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Domain\Main\Application\Query\CommentList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\Common\Application\EntityToArrayHydrator\Hydrator as EntityToArrayHydrator;
use \App\Domain\Main\Application\Command\RemoveCommentById;

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
}
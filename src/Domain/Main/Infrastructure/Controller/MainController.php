<?php

namespace App\Domain\Main\Infrastructure\Controller;

use BBLDN\CQRSBundle\QueryBus\QueryBus;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Domain\Main\Application\Query\CommentList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\Common\Application\EntityToArrayHydrator\Hydrator as EntityToArrayHydrator;

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
}
<?php

namespace App\Domain\Main\Infrastructure\Controller;

use Throwable;
use BBLDN\CQRSBundle\QueryBus\QueryBus;
use BBLDN\CQRSBundle\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

/* Контроллер с основными Action'ами для работы с комментариями */
class MainController extends AbstractController
{
    /**
     * Action который возвращает все комментарии
     *
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
        /* Создаем запрос CommentList */
        $query = new CommentList();

        /* Выполняем его */
        $commentList = $queryBus->execute($query);

        try {
            /* Преобразовываем результат в массив */
            $data = $entityToArrayHydrator->hydrateArray($commentList);
        } catch (RestException $e) {
            return $this->json($exceptionFormatter->format($e), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /* Возвращаем JSON Response */
        return $this->json(['data' => $data]);
    }

    /**
     * Action который удаляет комментарий по идентификатору (id)
     *
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
        /* Создаем команду RemoveCommentById */
        $command = new RemoveCommentById((int)$id);

        try {
            /* Выполняем её */
            $data = $commandBus->execute($command);
        } catch (Throwable $e) {
            return $this->json($exceptionFormatter->format($e), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /* Возвращаем JSON Response */
        return $this->json(['data' => $data]);
    }

    /**
     * Action который создает/обновляет комментарий
     *
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
            /* Пробуем получить и декодировать JSON из запроса */
            $requestData = $request->toArray();
        } catch (JsonException $e) {
            return $this->json($exceptionFormatter->format($e), Response::HTTP_BAD_REQUEST);
        }

        /** @var CreateOrUpdateCommentRequest $dto */
        try {
            /* Пробуем преобразовать полученные данные в CreateOrUpdateCommentRequest */
            $dto = $arrayToEntityHydrator->hydrateEntity($requestData, CreateOrUpdateCommentRequest::class);
        } catch (RestException|ValidateException $e) {
            return $this->json($exceptionFormatter->format($e), Response::HTTP_BAD_REQUEST);
        }

        /** @var CreateOrUpdateComment $mutation */
        $mutation = $dto->getInput();

        try {
            /* Создаём команду CreateOrUpdateCommentCommand и выполняем её */
            $comment = $commandBus->execute(new CreateOrUpdateCommentCommand($mutation));

            /* Преобразовываем результат в массив */
            $data = $entityToArrayHydrator->hydrateEntity($comment);
        } catch (Throwable $e) {
            return $this->json($exceptionFormatter->format($e), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /* Возвращаем JSON Response */
        return $this->json(['data' => $data]);
    }
}
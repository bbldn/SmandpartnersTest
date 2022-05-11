<?php

namespace App\Domain\Main\Application\CommandHandler\RemoveCommentById;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Domain\Main\Application\Command\RemoveCommentById;
use App\Domain\Main\Application\CommandHandler\RemoveCommentById\CommentRemover\Remover as CommentRemover;

/* Обработчик для App\Domain\Main\Application\Command\RemoveCommentById */
class CommandHandler
{
    private EntityManager $entityManager;

    private CommentRemover $commentRemover;

    /**
     * @param EntityManager $entityManager
     * @param CommentRemover $commentRemover
     */
    public function __construct(
        EntityManager $entityManager,
        CommentRemover $commentRemover
    )
    {
        $this->entityManager = $entityManager;
        $this->commentRemover = $commentRemover;
    }

    /**
     * @param RemoveCommentById $command
     * @return bool
     */
    public function __invoke(RemoveCommentById $command): bool
    {
        $result = $this->commentRemover->removeById($command->getId()); //Пытаемся найти и удалить комментарий
        if (true === $result) { // Если нашли и удалили
            $this->entityManager->flush(); //Сохраняем изменения в базу
        }

        return $result;
    }
}
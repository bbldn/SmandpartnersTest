<?php

namespace App\Domain\Main\Application\CommandHandler\RemoveCommentById;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Domain\Main\Application\Command\RemoveCommentById;
use App\Domain\Main\Application\CommandHandler\RemoveCommentById\CommentRemover\Remover as CommentRemover;

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
        $result = $this->commentRemover->removeById($command->getId());
        if (true === $result) {
            $this->entityManager->flush();
        }

        return $result;
    }
}
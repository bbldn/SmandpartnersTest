<?php

namespace App\Domain\Main\Application\CommandHandler\RemoveCommentById\CommentRemover;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Domain\Main\Application\CommandHandler\RemoveCommentById\CommentRemover\Repository\CommentRepository;

/* Ищет и удаляет комментарий */
class Remover
{
    private EntityManager $entityManager;

    private CommentRepository $commentRepository;

    /**
     * @param EntityManager $entityManager
     * @param CommentRepository $commentRepository
     */
    public function __construct(
        EntityManager $entityManager,
        CommentRepository $commentRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function removeById(int $id): bool
    {
        $comment = $this->commentRepository->findOne($id); //Ищем комментарий
        if (null === $comment) { //Если на находим
            return false; //То выходим
        }

        $this->entityManager->remove($comment); //Иначе удаляем

        return true;
    }
}
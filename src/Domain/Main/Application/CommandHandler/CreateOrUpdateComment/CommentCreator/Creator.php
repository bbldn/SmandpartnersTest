<?php

namespace App\Domain\Main\Application\CommandHandler\CreateOrUpdateComment\CommentCreator;

use App\Domain\Common\Domain\Entity\Base\Comment;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Domain\Main\Domain\Entity\Input\CreateOrUpdateComment;
use App\Domain\Main\Application\CommandHandler\CreateOrUpdateComment\CommentCreator\Repository\CommentRepository;

/* Создаёт или обновляет комментарий */
class Creator
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
     * Возвращает комментарий который необходимо заполнить данными из CreateOrUpdateComment
     *
     * @param CreateOrUpdateComment $mutation
     * @return Comment
     */
    private function getCommentByMutation(CreateOrUpdateComment $mutation): Comment
    {
        $id = (int)$mutation->getId();
        if ($id < 1) { //Если идентификатор меньше 1, значит создаём новый идентификатор
            $comment = new Comment();
            $this->entityManager->persist($comment);

            return $comment;
        }

        /** @psalm-var Comment */
        return $this->commentRepository->findOne($id);
    }

    /**
     * Тут стоит обратить внимание, что в этот метод необходимо передавать провалидированный
     * CreateOrUpdateComment (о чём свидетельствует имея параметра $validatedMutation)
     * В реальной системе стоило бы обернуть CreateOrUpdateComment во враппер CreateOrUpdateCommentValidated
     * То сейчас я этого делать не стал, для упрощения
     *
     * @param CreateOrUpdateComment $validatedMutation
     * @return Comment
     */
    public function createOrUpdate(CreateOrUpdateComment $validatedMutation): Comment
    {
        $comment = $this->getCommentByMutation($validatedMutation);

        $comment->setAuthor('Людмила Голубкова');
        $comment->setComment($validatedMutation->getComment());

        return $comment;
    }
}
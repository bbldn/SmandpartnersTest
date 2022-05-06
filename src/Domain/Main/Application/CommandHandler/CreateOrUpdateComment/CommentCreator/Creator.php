<?php

namespace App\Domain\Main\Application\CommandHandler\CreateOrUpdateComment\CommentCreator;

use App\Domain\Common\Domain\Entity\Base\Comment;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Domain\Main\Domain\Entity\Input\CreateOrUpdateComment;
use App\Domain\Main\Application\CommandHandler\CreateOrUpdateComment\CommentCreator\Repository\CommentRepository;

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
     * @param CreateOrUpdateComment $mutation
     * @return Comment
     */
    private function getCommentByMutation(CreateOrUpdateComment $mutation): Comment
    {
        /** @var int $id */
        $id = $mutation->getId();
        if ($id < 1) {
            $comment = new Comment();
            $this->entityManager->persist($comment);

            return $comment;
        }

        /** @psalm-var Comment */
        return $this->commentRepository->findOne($id);
    }

    /**
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
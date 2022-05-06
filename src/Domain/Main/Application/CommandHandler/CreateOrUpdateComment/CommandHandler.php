<?php

namespace App\Domain\Main\Application\CommandHandler\CreateOrUpdateComment;

use App\Domain\Common\Domain\Entity\Base\Comment;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Domain\Main\Application\Command\CreateOrUpdateComment;
use App\Domain\Main\Application\CommandHandler\CreateOrUpdateComment\CommentCreator\Creator as CommentCreator;

class CommandHandler
{
    private EntityManager $entityManager;

    private CommentCreator $commentCreator;

    /**
     * @param EntityManager $entityManager
     * @param CommentCreator $commentCreator
     */
    public function __construct(
        EntityManager $entityManager,
        CommentCreator $commentCreator
    )
    {
        $this->entityManager = $entityManager;
        $this->commentCreator = $commentCreator;
    }

    /**
     * @param CreateOrUpdateComment $command
     * @return Comment
     */
    public function __invoke(CreateOrUpdateComment $command): Comment
    {
        $comment = $this->commentCreator->createOrUpdate($command->getMutation());

        $this->entityManager->flush();

        return $comment;
    }
}
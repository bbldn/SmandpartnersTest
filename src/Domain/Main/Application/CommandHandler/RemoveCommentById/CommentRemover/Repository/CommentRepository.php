<?php

namespace App\Domain\Main\Application\CommandHandler\RemoveCommentById\CommentRemover\Repository;

use App\Domain\Common\Domain\Entity\Base\Comment;

interface CommentRepository
{
    /**
     * @param int $id
     * @return Comment|null
     */
    public function findOne(int $id): ?Comment;
}
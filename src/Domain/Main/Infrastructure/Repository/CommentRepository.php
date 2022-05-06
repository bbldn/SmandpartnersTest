<?php

namespace App\Domain\Main\Infrastructure\Repository;

use App\Domain\Common\Domain\Entity\Base\Comment;
use App\Domain\Common\Infrastructure\Repository\Base\CommentRepository as Base;
use App\Domain\Main\Application\QueryHandler\CommentList\Repository\CommentRepository as CommentRepositoryCommentList;
use App\Domain\Main\Application\CommandHandler\RemoveCommentById\CommentRemover\Repository\CommentRepository as CommentRepositoryCommentRemover;

class CommentRepository extends Base implements
    CommentRepositoryCommentList,
    CommentRepositoryCommentRemover
{
    /**
     * @param int $id
     * @return Comment|null
     */
    public function findOne(int $id): ?Comment
    {
        return $this->find($id);
    }
}
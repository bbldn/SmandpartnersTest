<?php

namespace App\Domain\Main\Application\QueryHandler\CommentList\Repository;

use App\Domain\Common\Domain\Entity\Base\Comment;

interface CommentRepository
{
    /**
     * @return Comment[]
     *
     * @psalm-return list<Comment>
     *
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function findAll();
}
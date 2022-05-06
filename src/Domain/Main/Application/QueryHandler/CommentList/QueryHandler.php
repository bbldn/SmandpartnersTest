<?php

namespace App\Domain\Main\Application\QueryHandler\CommentList;

use App\Domain\Common\Domain\Entity\Base\Comment;
use App\Domain\Main\Application\Query\CommentList;
use App\Domain\Main\Application\QueryHandler\CommentList\Repository\CommentRepository;

class QueryHandler
{
    private CommentRepository $commentRepository;

    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param CommentList $query
     * @return Comment[]
     *
     * @psalm-return list<Comment>
     */
    public function __invoke(CommentList $query): array
    {
        return $this->commentRepository->findAll();
    }
}
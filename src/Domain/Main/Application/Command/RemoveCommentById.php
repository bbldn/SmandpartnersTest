<?php

namespace App\Domain\Main\Application\Command;

use BBLDN\CQRSBundle\CommandBus\Command;
use BBLDN\CQRSBundle\CommandBus\Annotation as CQRS;
use App\Domain\Main\Application\QueryHandler\CommentList\QueryHandler;

#[CQRS\CommandHandler(class: QueryHandler::class)]
class RemoveCommentById implements Command
{
    private int $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
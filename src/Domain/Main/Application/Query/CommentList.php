<?php

namespace App\Domain\Main\Application\Query;

use BBLDN\CQRSBundle\QueryBus\Query;
use BBLDN\CQRSBundle\QueryBus\Annotation as CQRS;
use App\Domain\Main\Application\QueryHandler\CommentList\QueryHandler;

#[CQRS\QueryHandler(class: QueryHandler::class)]
class CommentList implements Query
{
}
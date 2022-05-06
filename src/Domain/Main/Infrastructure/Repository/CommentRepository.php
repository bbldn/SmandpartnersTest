<?php

namespace App\Domain\Main\Infrastructure\Repository;

use App\Domain\Common\Infrastructure\Repository\Base\CommentRepository as Base;
use App\Domain\Main\Application\QueryHandler\CommentList\Repository\CommentRepository as CommentRepositoryCommentList;

class CommentRepository extends Base implements CommentRepositoryCommentList
{
}
<?php

namespace App\Domain\Main\Application\Command;

use BBLDN\CQRSBundle\CommandBus\Command;
use BBLDN\CQRSBundle\CommandBus\Annotation as CQRS;
use App\Domain\Main\Domain\Entity\Input\CreateOrUpdateComment as Mutation;
use App\Domain\Main\Application\CommandHandler\CreateOrUpdateComment\CommandHandler;

/* Команда создания/изменения комментария */
#[CQRS\CommandHandler(class: CommandHandler::class)]
class CreateOrUpdateComment implements Command
{
    private Mutation $mutation;

    /**
     * @param Mutation $mutation
     */
    public function __construct(Mutation $mutation)
    {
        $this->mutation = $mutation;
    }

    /**
     * @return Mutation
     */
    public function getMutation(): Mutation
    {
        return $this->mutation;
    }
}
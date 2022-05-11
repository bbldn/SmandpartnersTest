<?php

namespace App\Domain\Main\Domain\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Domain\Main\Domain\Entity\Input\CreateOrUpdateComment;

/* DTO для валидации запроса на создание и удаления комментария */
class CreateOrUpdateCommentRequest
{
    #[Assert\NotNull]
    #[Assert\Valid]
    private ?CreateOrUpdateComment $input = null;

    /**
     * @return CreateOrUpdateComment|null
     */
    public function getInput(): ?CreateOrUpdateComment
    {
        return $this->input;
    }

    /**
     * @param CreateOrUpdateComment|null $input
     * @return CreateOrUpdateCommentRequest
     */
    public function setInput(?CreateOrUpdateComment $input): self
    {
        $this->input = $input;

        return $this;
    }
}
<?php

namespace App\Domain\Main\Domain\Entity\Input;

use App\Domain\Common\Domain\Entity\Base\Comment;
use Symfony\Component\Validator\Constraints as Assert;
use BBLDN\EntityExistsValidatorBundle\Doctrine\Validator as BBLDNValidator;

class CreateOrUpdateComment
{
    /* Идентификатор атрибута */
    #[Assert\Sequentially([
        new Assert\NotNull(),
        new Assert\Type("integer"),
        new BBLDNValidator\EntityExistsByField(entityClass: Comment::class, field: "id")
    ])]
    protected ?int $id = null;

    /* Идентификатор языка */
    #[Assert\Sequentially([
        new Assert\NotNull(),
        new Assert\Type("string"),
        new Assert\Length(min: 1, max: 1024),
    ])]
    protected ?string $comment = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CreateOrUpdateComment
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return CreateOrUpdateComment
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
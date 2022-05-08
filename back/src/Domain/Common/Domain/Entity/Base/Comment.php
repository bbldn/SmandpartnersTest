<?php

namespace App\Domain\Common\Domain\Entity\Base;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Common\Infrastructure\Repository\Base\CommentRepository;

#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: "`comments`")]
#[ORM\Index(name: "created_at_idx", columns: ["created_at"])]
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    /* Идентификатор */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "`id`", type: Types::INTEGER, options: ["unsigned" => true])]
    private ?int $id = null;

    /* Комментарий */
    #[ORM\Column(name: "`comment`", type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    /* Автор */
    #[ORM\Column(name: "`author`", type: Types::STRING, length: 255, nullable: true)]
    private ?string $author = null;

    /* Дата и время создания */
    #[ORM\Column(name: "`created_at`", type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Comment
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
     * @return Comment
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     * @return Comment
     */
    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable|null $createdAt
     * @return Comment
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function updatedTimestamp(): void
    {
        if (null === $this->getCreatedAt()) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
    }
}
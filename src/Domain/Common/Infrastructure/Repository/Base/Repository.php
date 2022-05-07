<?php

namespace App\Domain\Common\Infrastructure\Repository\Base;

use Psr\Log\LoggerInterface as Logger;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template T
 * @template-extends ServiceEntityRepository<T>
 *
 * @psalm-suppress InvalidTemplateParam
 */
abstract class Repository extends ServiceEntityRepository
{
    protected Logger $logger;

    /**
     * @param Logger $logger
     * @param ManagerRegistry $registry
     * @param string $entityClass
     *
     * @psalm-param class-string<T> $entityClass
     */
    public function __construct(Logger $logger, ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
        $this->logger = $logger;
    }
}
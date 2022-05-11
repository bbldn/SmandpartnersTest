<?php

namespace App\Domain\Common\Application\EntityToArrayHydrator;

use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Serializer\Serializer;
use App\Domain\Common\Domain\Exception\RestException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/* Преобразовывает сущность в массив */
class Hydrator
{
    private Logger $logger;

    private Serializer $serializer;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
    }

    /**
     * @param object $entity
     * @return array
     * @throws RestException
     */
    public function hydrateEntity(object $entity): array
    {
        return $this->hydrate($entity);
    }

    /**
     * @param object[] $entityList
     * @return array
     * @throws RestException
     *
     * @psalm-param list<object> $entityList
     */
    public function hydrateArray(array $entityList): array
    {
        $result = [];
        foreach ($entityList as $entity) {
            $result[] = $this->hydrate($entity);
        }

        return $result;
    }

    /**
     * @param object $entity
     * @return array
     * @throws RestException
     */
    private function hydrate(object $entity): array
    {
        try {
            return $this->serializer->normalize($entity);
        } catch (ExceptionInterface $e) {
            $this->logger->error((string)$e);
            throw new RestException('Неизвестная ошибка обратитесь к администратору');
        }
    }
}
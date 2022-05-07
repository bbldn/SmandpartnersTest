<?php

namespace App\Domain\Common\Application\ArrayToEntityHydrator;

use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

class Hydrator
{
    private Logger $logger;

    private Serializer $serializer;

    public function __construct(Logger $logger)
    {
        $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();
        $propertyTypeExtractor = new PropertyInfoExtractor(
            [$reflectionExtractor],
            [$phpDocExtractor, $reflectionExtractor],
            [$phpDocExtractor],
            [$reflectionExtractor],
            [$reflectionExtractor]
        );

        $normalizer = new ObjectNormalizer(null, null, null, $propertyTypeExtractor);

        $this->logger = $logger;
        $this->serializer = new Serializer([new ArrayDenormalizer(), $normalizer]);
    }

    /**
     * @param array $data
     * @param string $type
     * @return mixed
     *
     * @psalm-param array<string, mixed> $data
     */
    public function hydrateEntity(array $data, string $type)
    {
        return $this->hydrate($data, $type, false);
    }

    /**
     * @param array $data
     * @param string $type
     * @return mixed
     *
     * @psalm-param array<string, mixed> $data
     */
    public function hydrateArray(array $data, string $type)
    {
        return $this->hydrate($data, $type, true);
    }

    /**
     * @param array $data
     * @param string $type
     * @param bool $isArray
     * @return mixed
     *
     * @psalm-param array<string, mixed> $data
     */
    private function hydrate(array $data, string $type, bool $isArray)
    {
        if (true === $isArray) {
            $type = sprintf('%s[]', $type);
        }

        try {
            return $this->serializer->denormalize($data, $type);
        } catch (ExceptionInterface $e) {
            $this->logger->error((string)$e);
        }

        return null;
    }
}
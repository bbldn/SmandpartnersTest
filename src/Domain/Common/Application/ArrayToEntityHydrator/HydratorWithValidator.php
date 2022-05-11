<?php

namespace App\Domain\Common\Application\ArrayToEntityHydrator;

use Throwable;
use Psr\Log\LoggerInterface as Logger;
use App\Domain\Common\Domain\Exception\RestException;
use App\Domain\Common\Application\Validator\Validator;
use App\Domain\Common\Domain\Exception\ValidateException;

class HydratorWithValidator
{
    private Logger $logger;

    private Hydrator $hydrator;

    private Validator $validator;

    /**
     * @param Logger $logger
     * @param Hydrator $hydrator
     * @param Validator $validator
     */
    public function __construct(
        Logger $logger,
        Hydrator $hydrator,
        Validator $validator
    )
    {
        $this->logger = $logger;
        $this->hydrator = $hydrator;
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @param string $type
     * @return mixed
     * @throws ValidateException
     * @throws RestException
     *
     * @psalm-param class-string $type
     * @psalm-param array<string, mixed> $data
     */
    public function hydrateEntity(array $data, string $type)
    {
        try {
            $result = $this->hydrator->hydrateEntity($data, $type);
        } catch (Throwable $e) {
            $this->logger->error((string)$e);
            throw new RestException('Ошибка сервера. Обратитесь к администратору.');
        }

        $this->validator->validate($result);

        return $result;
    }

    /**
     * @param array $data
     * @param string $type
     * @return mixed
     * @throws ValidateException
     * @throws RestException
     *
     * @psalm-param class-string $type
     * @psalm-param array<string, mixed> $data
     */
    public function hydrateArray(array $data, string $type)
    {
        try {
            $result = $this->hydrator->hydrateArray($data, $type);
        } catch (Throwable $e) {
            $this->logger->error((string)$e);
            throw new RestException('Ошибка сервера. Обратитесь к администратору.');
        }

        foreach ($result as $instance) {
            $this->validator->validate($instance);
        }

        return $result;
    }
}
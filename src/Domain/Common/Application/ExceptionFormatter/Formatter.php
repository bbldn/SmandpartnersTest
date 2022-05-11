<?php

namespace App\Domain\Common\Application\ExceptionFormatter;

use Throwable;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Psr\Log\LoggerInterface as Logger;
use App\Domain\Common\Domain\Exception\RestException;
use App\Domain\Common\Domain\Exception\ValidateException;

/* Форматирует исключения в формат понятный FrontEnd'у */
class Formatter
{
    private Logger $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Throwable $throwable
     * @return array
     *
     * @psalm-return array{message: string, exception: string, errors?: mixed}
     */
    public function format(Throwable $throwable): array
    {
        if (true === is_a($throwable, ValidateException::class)) {
            return [
                'exception' => 'ValidateException',
                'message' => $throwable->getMessage(),
                'errors' => $throwable->getErrors(),
            ];
        }

        if (true === is_a($throwable, RestException::class)) {
            return [
                'exception' => 'RestException',
                'message' => $throwable->getMessage(),
            ];
        }

        if (true === is_a($throwable, JsonException::class)) {
            return [
                'exception' => 'RestException',
                'message' => 'Неверный запрос',
            ];
        }

        $this->logger->error((string)$throwable);

        return [
            'exception' => 'RestException',
            'message' => 'Неизвестная ошибка обратитесь к администратору',
        ];
    }
}
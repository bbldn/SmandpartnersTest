<?php

namespace App\Domain\Common\Domain\Exception;

use Exception;
use Throwable;

class ValidateException extends Exception
{
    /**
     * @var string[]
     *
     * @psalm-var array<string, string>
     */
    private array $errors;

    /**
     * @param string[] $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     *
     * @psalm-param array<string, string> $list
     */
    public function __construct($errors = [], $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return string[]
     *
     * @psalm-return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
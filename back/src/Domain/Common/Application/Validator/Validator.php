<?php

namespace App\Domain\Common\Application\Validator;

use App\Domain\Common\Domain\Exception\ValidateException;
use Symfony\Component\Validator\Mapping\MetadataInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ContextualValidatorInterface;

class Validator implements ValidatorInterface
{
    private ValidatorInterface $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function hasMetadataFor($value): bool
    {
        return $this->validator->hasMetadataFor($value);
    }

    /**
     * @inheritDoc
     */
    public function getMetadataFor($value): MetadataInterface
    {
        return $this->validator->getMetadataFor($value);
    }

    /**
     * @inheritDoc
     */
    public function startContext(): ContextualValidatorInterface
    {
        return $this->validator->startContext();
    }

    /**
     * @inheritDoc
     */
    public function inContext(ExecutionContextInterface $context): ContextualValidatorInterface
    {
        return $this->validator->inContext($context);
    }

    /**
     * @inheritDoc
     */
    public function validateProperty($object, string $propertyName, $groups = null): ConstraintViolationListInterface
    {
        return $this->validator->validateProperty($object, $propertyName, $groups);
    }

    /**
     * @inheritDoc
     */
    public function validatePropertyValue($objectOrClass, string $propertyName, $value, $groups = null): ConstraintViolationListInterface
    {
        return $this->validator->validatePropertyValue($objectOrClass, $propertyName, $value, $groups);
    }

    /**
     * @param string[] $errors
     * @return string
     *
     * @psalm-param array<string, string> $errors
     */
    private function errorsToMessage(array $errors): string
    {
        $message = '';
        foreach ($errors as $path => $error) {
            $message .= "$path: $error" . PHP_EOL;
        }

        return $message;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return string[]
     *
     * @psalm-return array<string, string>
     */
    private function formatErrors(ConstraintViolationListInterface $errors): array
    {
        $result = [];
        foreach ($errors as $error) {
            /** @var ConstraintViolationInterface $error */
            $property = $error->getPropertyPath();
            $tmp = explode('.', $property);
            $result[end($tmp)] = (string)$error->getMessage();
        }

        return $result;
    }

    /**
     * @inheritDoc
     * @throws ValidateException
     */
    public function validate($value, $constraints = null, $groups = null): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($value, $constraints, $groups);
        if (count($errors) > 0) {
            $formattedMessages = $this->formatErrors($errors);
            $message = $this->errorsToMessage($formattedMessages);
            throw new ValidateException($formattedMessages, $message);
        }

        return $errors;
    }
}
<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidEntityException extends \Exception
{
    private array $errors;

    public function __construct(string $message, ConstraintViolationListInterface $violations)
    {
        foreach ($violations as $constraint) {
            $this->errors[$constraint->getPropertyPath()][] = $constraint->getMessage();
        }
        parent::__construct($message);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

<?php


namespace App\Controller\Helper;


use Symfony\Component\Validator\ConstraintViolationList;

class ConstraintValidationFailErrorResponse extends GeneralErrorResponse
{
    private const ERROR_NAME = 'invalidData';
    private const TITLE = 'One or more fields has invalid data';
    private const TYPE = 'about:blank';

    protected function setType(): string
    {
        return self::TYPE;
    }

    protected function setTitle(): string
    {
        return self::TITLE;
    }

    protected function getErrorName(): string
    {
        return self::ERROR_NAME;
    }

    /**
     * @throws \Exception
     */
    protected function getErrorContent(mixed $errorContent): mixed {
        /** @var ConstraintViolationList $errorContent */
        $result = [];
        foreach($errorContent->getIterator() as $violation) {
            $result[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $result;
    }
}


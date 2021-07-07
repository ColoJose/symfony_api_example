<?php


namespace App\Controller\Helper;

class MissingFieldErrorResponse extends GeneralErrorResponse {

    private const TITLE = 'Required fields are missing';
    private const TYPE = 'about:blank';
    private const NAME = 'missingFields';

    protected function setType(): string {
        return self::TYPE;
    }

    protected function setTitle(): string {
        return self::TITLE;
    }


    protected function getErrorName(): string
    {
        return self::NAME;
    }

    protected function getErrorContent(mixed $errorContent): mixed {
        return $errorContent;
    }
}


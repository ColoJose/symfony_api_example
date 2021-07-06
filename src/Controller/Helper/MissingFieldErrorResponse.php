<?php


namespace App\Controller\Helper;


class MissingFieldErrorResponse extends GeneralErrorResponse {

    private const TITLE = 'Required fields are missing';
    private const TYPE = 'about:blank';
    private const NAME = 'missingFields';

    protected function setType() {
        return self::TYPE;
    }

    protected function setTitle() {
        return self::TITLE;
    }


    protected function getErrorName()
    {
        return self::NAME;
    }

    protected function getErrorContent(mixed $errorContent) {
        return $errorContent;
    }
}


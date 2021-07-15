<?php


namespace App\Controller\Helper;


use App\Constant;
use App\Exception\InvalidStatusCodeException;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class GeneralErrorResponse {

    public const DEFAULT_CONTENT_TYPE = 'application/problem';
    public const INVALID_STATUS_CODE_MESSAGE = "Status code must begin with 4xx or 5xx";

    abstract protected function setType(): string;
    abstract protected function setTitle(): string;
    abstract protected function getErrorName(): string;
    abstract protected function getErrorContent(mixed $errorContent): mixed;

    public function make(mixed $errorContent, string $format='json', int $statusCode = 400): Response {
        $response = new JsonResponse([
            "type" => $this->setType(),
            "title" => $this->setTitle(),
            "status" => $statusCode,
            $this->getErrorName() => $this->getErrorContent($errorContent)
        ]);

        $response->headers->set('Content-Type', sprintf('%s+%s', self::DEFAULT_CONTENT_TYPE, $format));
        $this->setStatusCode($statusCode, $response);
        return $response;
    }

    private function setStatusCode(int $statusCode, Response $response) {
        if ($statusCode < 400 || $statusCode > 599) {
            throw new InvalidStatusCodeException(self::INVALID_STATUS_CODE_MESSAGE);
        }
        $response->setStatusCode($statusCode);
    }

}

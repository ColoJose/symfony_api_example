<?php


namespace App\Controller\Helper;


use App\Constant;
use App\Exception\InvalidStatusCodeException;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class GeneralErrorResponse {

    public const DEFAULT_CONTENT_TYPE = 'application/problem';

    abstract protected function setType();
    abstract protected function setTitle();
    abstract protected function getErrorName();
    abstract protected function getErrorContent(mixed $errorContent);

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
            throw new InvalidStatusCodeException(Constant::INVALID_STATUS_CODE_MESSAGE);
        }
        $response->setStatusCode($statusCode);
    }

}

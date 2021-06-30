<?php


namespace App\Controller\Helper;


use App\Constant;
use App\Exception\InvalidStatusCodeException;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GeneralErrorResponse {

    public const DEFAULT_CONTENT_TYPE = 'application/problem';

    public function __construct() {}

    public function make(string $type, string $title, string $format='json', int $statusCode = 400): Response {
        $response = new JsonResponse([
            "type" => $type,
            "title" => $title,
            "status" => $statusCode
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

<?php


namespace App\Controller\Helper;


use App\Controller\Helper\GeneralErrorResponse;
use App\Controller\Helper\Validatable;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * The purpose of this class is check
 * Class FieldExistsValidator
 * @package App\Tests\Controller\Helper
 */
class FieldExistsValidator implements Validatable
{

    private $fieldsToCheck;
    private $fieldsRequest;
    private $errorResponse;

    /**
     * FieldExistsValidator constructor.
     */
    public function __construct(array $fieldsToCheck, array $fieldsRequest)
    {
        $this->fieldsToCheck = $fieldsToCheck;
        $this->fieldsRequest = $fieldsRequest;
    }

    public function isValid(): bool
    {
        $isValid = true;
        $invalidFields = array();
        foreach($this->fieldsToCheck as $fieldToCheck) {
            if(!array_key_exists($fieldToCheck, $this->fieldsRequest)) {
                $isValid = false;
                array_push($invalidFields, $fieldToCheck);
            }
        }

        if ($invalidFields) {
            $this->setErrorResponse($invalidFields);
        }

        return $isValid;
    }

    public function getErrorResponse(): ?JsonResponse {
        return $this->errorResponse;
    }

    private function setErrorResponse(array $invalidFields) {
        $this->errorResponse = (new MissingFieldErrorResponse())->make($invalidFields);
    }
}


<?php


namespace App\Tests\Controller\Helper;


use App\Controller\Helper\FieldExistsValidator;
use App\Controller\Helper\MissingFieldErrorResponse;
use http\Env\Response;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;


class FieldExistsValidatorTest extends KernelTestCase {

    private $fieldExistsValidatorValidCheck;
    private $fieldExistsValidatorInvalidCheck;

    private $singleFieldToCheck;
    private $severalFieldsToCheck;
    private $singleFieldRequest;
    private $severalFieldsRequest;

    /**
     * @before
     */
    public function setUp(): void {
        $this->singleFieldToCheck = array("name");
        $this->severalFieldsToCheck = array("name", "surname");
        $this->singleFieldRequest = ["name" => "name"];
        $this->severalFieldsRequest = ["name" => "name", "other" => "other"];
        $this->fieldExistsValidatorValidCheck = new FieldExistsValidator($this->singleFieldToCheck, $this->severalFieldsRequest);
        $this->fieldExistsValidatorInvalidCheck = new FieldExistsValidator($this->severalFieldsToCheck, $this->singleFieldRequest);
    }

    /**
     * @test
     */
    public function givenAnEmptyFieldsToCheck_whenCallIsValid_thenShouldReturnTrue() {
        $fieldExistsValidator = new FieldExistsValidator(array(), $this->singleFieldRequest);
        $this->assertTrue($fieldExistsValidator->isValid());
    }

    /**
     * @test
     */
    public function givenSomeFieldsToCheck_whenCallIsValid_thenShouldReturnTrueIfAllOfThisExistsInFieldsRequest() {
        $this->assertTrue($this->fieldExistsValidatorValidCheck->isValid());
    }

    /**
     * @test
     */
    public function givenSomeFieldsToCheck_whenCallIsValid_thenShouldReturnFalseIfAnyOfThisIsNotInFieldsRequest() {
        $this->assertFalse($this->fieldExistsValidatorInvalidCheck->isValid());
    }

    /**
     * @test
     */
    public function whenIsValidReturnsTrue_thenGetErrorResponseShouldReturnNull() {
        $this->fieldExistsValidatorValidCheck->isValid();
        $this->assertNull($this->fieldExistsValidatorValidCheck->getErrorResponse());
    }

    /**
     * @test
     */
    public function whenIsValidReturnsFalse_thenGetErrorResponseShouldReturnAJsonResponse() {
        $this->fieldExistsValidatorInvalidCheck->isValid();
        $errorResponse = $this->fieldExistsValidatorInvalidCheck->getErrorResponse();
        $this->assertTrue($errorResponse instanceof JsonResponse);
    }
}


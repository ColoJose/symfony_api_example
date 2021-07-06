<?php


namespace App\Tests\Controller\Helper;


use App\Controller\Helper\MissingFieldErrorResponse;
use App\Exception\InvalidStatusCodeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MissingFieldErrorResponseTest extends KernelTestCase {

    private $missingFieldErrorResponse;
    private $errorContent;

    /**
     * @before
     */
    public function setUp(): void
    {
        $this->errorContent = ['fooFieldMissing'];
        $this->missingFieldErrorResponse = (new MissingFieldErrorResponse())->make($this->errorContent);
    }

    /**
     * @test
     */
    public function defaultContentTypesIsApplicationProblemJson() {
        $this->assertEquals('application/problem+json', $this->missingFieldErrorResponse->headers->get('Content-Type'));
    }

    /**
     * @test
     */
    public function givenAFormat_whenMakeIsCallen_thenContentTypeShouldBeApplicationProblemPlusThisFormat() {
        $expectedFormat = 'xml';
        $missingFieldsErrorResponse = (new MissingFieldErrorResponse())->make($this->errorContent, $expectedFormat);
        $this->assertEquals(sprintf('application/problem+%s', $expectedFormat), $missingFieldsErrorResponse->headers->get('Content-Type'));
    }

    /**
     * @test
     */
    public function defaultStatudCodeIs400BadRequest() {
        $this->assertEquals(400, $this->missingFieldErrorResponse->getStatusCode());
    }

    /**
     * @test
     */
    public function givenAStatusCode_whenMakeIsCalled_thenStatusCodeShouldBeThisOne() {
        $expectedStatusCode = 500;
        $generalErrorResponse = (new MissingFieldErrorResponse())->make($this->errorContent, 'xml', $expectedStatusCode);
        $this->assertEquals($expectedStatusCode, $generalErrorResponse->getStatusCode());
    }

    /**
     * @test
     */
    public function givenAStatusCodeWhichNotBeginsWithFourOrFive_whenMakeIsCalled_thenShouldRaiseAnInvalidStatusCodeException() {
        $this->expectException(InvalidStatusCodeException::class);

        $invalidStatusCode = 201;
        $generalErrorResponse = (new MissingFieldErrorResponse())->make($this->errorContent, 'json', $invalidStatusCode);
    }

    /**
     * @test
     */
    public function responseErrorShouldHaveTypeTitleAndStatus() {
        $responseBody = json_decode($this->missingFieldErrorResponse->getContent(), true);
        $this->assertNotEmpty($responseBody["type"]);
        $this->assertNotEmpty($responseBody["title"]);
        $this->assertNotEmpty($responseBody["status"]);
    }

    /**
     * @test
     */
    public function whenMakeIsCalled_thenShouldReturnMissingParametersField() {
        $responseBody = json_decode($this->missingFieldErrorResponse->getContent(), true);
        $this->assertNotEmpty($responseBody["missingFields"]);
    }
}


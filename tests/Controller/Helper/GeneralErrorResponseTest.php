<?php


namespace App\Tests\Controller\Helper;


use App\Exception\InvalidStatusCodeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Controller\Helper\GeneralErrorResponse;

class GeneralErrorResponseTest extends KernelTestCase {

    private $generalErrorResponse;
    private $type = "http://resource";
    private $title = "a title";


    /**
     * @before
     */
    public function setUp(): void
    {
        $this->generalErrorResponse = (new GeneralErrorResponse())->make($this->type, $this->title);
    }

    /**
     * @test
     */
    public function defaultContentTypesIsApplicationProblemJson() {
        $this->assertEquals('application/problem+json', $this->generalErrorResponse->headers->get('Content-Type'));
    }

    /**
     * @test
     */
    public function given_aFormat_whenGeneralErrorResponseIsMake_then_contentTypeShouldBeApplicationProblemPlusThisFormat() {
        $expectedFormat = 'xml';
        $generalErrorResponse = (new GeneralErrorResponse())->make($this->type, $this->title, $expectedFormat);
        $this->assertEquals(sprintf('application/problem+%s', $expectedFormat), $generalErrorResponse->headers->get('Content-Type'));
    }

    /**
     * @test
     */
    public function defaultStatudCodeIs400BadRequest() {
        $this->assertEquals(400, $this->generalErrorResponse->getStatusCode());
    }

    /**
     * @test
     */
    public function given_aStatusCode_whenGeneralErrorResponseIsMake_then_statusCodeShouldBeThisOne() {
        $expectedStatusCode = 500;
        $generalErrorResponse = (new GeneralErrorResponse())->make($this->type, $this->title, 'xml', $expectedStatusCode);
        $this->assertEquals($expectedStatusCode, $generalErrorResponse->getStatusCode());
    }

    /**
     * @test
     */
    public function given_aStatusCodeWhichNotBeginsWithFourOrFive_whenGeneralErrorResponseIsMake_then_shouldRaiseAnInvalidStatusCodeException() {
        $this->expectException(InvalidStatusCodeException::class);

        $invalidStatusCode = 201;
        $generalErrorResponse = (new GeneralErrorResponse())->make($this->type, $this->title, 'json', $invalidStatusCode);
    }

    /**
     * @test
     */
    public function generalErrorResponseErrorShouldHaveTypeTitleAndStatusInTheResponse() {
        $response_body = json_decode($this->generalErrorResponse->getContent(), true);
        $this->assertEquals($this->type, $response_body["type"]);
        $this->assertEquals($this->title, $response_body["title"]);
        $this->assertEquals(400,  $response_body["status"]);
    }
}
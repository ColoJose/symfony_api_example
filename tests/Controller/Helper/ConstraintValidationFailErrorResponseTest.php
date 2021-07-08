<?php

namespace App\Tests\Controller\Helper;

use App\Controller\Helper\ConstraintValidationFailErrorResponse;
use App\Entity\House;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Validation;

class ConstraintValidationFailErrorResponseTest extends KernelTestCase {

    private $validator;
    private $house;
    private $constraintValidationFailErrorResponse;
    private $violations;

    /**
     * @before
     */
    public function setUp(): void {
        $this->validator = Validation::createValidator();
        $this->house = new House();
        $this->house->setFloors(-2);
        $this->violations = $this->validator->validate($this->house->getFloors(), new Positive());
        $this->constraintValidationFailErrorResponse = (new ConstraintValidationFailErrorResponse())->make($this->violations);
    }

    /**
     * @test
     */
    public function whenMakeIsCalled_thenShouldReturnInvalidDataField() {
        $responseBody = json_decode($this->constraintValidationFailErrorResponse->getContent(), true);
        $this->assertNotEmpty($responseBody['invalidData']);
    }
}


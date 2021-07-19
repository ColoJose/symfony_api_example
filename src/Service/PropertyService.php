<?php

namespace App\Service;

use App\Entity\Flat;
use App\Entity\House;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PropertyService {

    private $propertyRepository;
    private $validator;

    public function __construct(PropertyRepository $propertyRepository, ValidatorInterface $validator) {
        $this->propertyRepository = $propertyRepository;
        $this->validator = $validator;
    }

    public function findAll() {
        return $this->propertyRepository->findAll();
    }

    public function find(int $id) {
        return $this->propertyRepository->find($id);
    }

    public function delete(Property $property) {
        $this->propertyRepository->delete($property);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(string $propertyType, array $data) {
        $property = null;
        if ($propertyType == 'flat') {
            $property = $this->createFlat($data);
        }
        if ($propertyType == 'house') {
            $property = $this->createHouse($data);
        }

        $errors = $this->validator->validate($property);

        if (count($errors) > 0) {
            return $errors;
        } else {
            $this->propertyRepository->insert($property);
            return null;
        }
    }

    /**
     * @param $data
     * @return House
     */
    private function createHouse($data): Property {
        $house = new House();
        $this->setCommonProperties($house, $data);
        $house->setFloors($data['floors']);
        $house->setHasGarden($data['hasGarden']);
        if ($data['hasGarden']) {
            $house->setGardenSqm($data['gardenSqm']);
        }

        return $house;
    }

    /**
     * @param $data
     * @return Flat
     */
    public function createFlat($data): Property {
        $house = new Flat();
        $this->setCommonProperties($house, $data);
        $house->setIsLoft($data['isLoft']);
        $house->setAcceptPets($data['acceptPets']);

        return $house;
    }

    private function setCommonProperties($property, $data) {
        /** @var  Property $property */
        $property->setStreet($data['street']);
        $property->setNumber($data['number']);
        if ($data['zipCode']) {
            $property->setZipCode($data['zipCode']);
        }
        $property->setSqm($data['sqm']);
        $property->setLocation($data['location']);
    }

    public function findBy(array $searchCriteria) {
        return $this->propertyRepository->findBy($searchCriteria);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function update($property, array $data) {
        /**
         * @var string $street
         * @var float $sqm
         * @var string $location
         * @var int $number
         * @var int $zipCode
         */
        extract($data);
        if (isset($street)) { $property->setStreet($street); };
        if (isset($sqm)) { $property->setSqm($sqm); };
        if (isset($number)) { $property->setNumber($number); };
        if (isset($zipCode)) { $property->setZipCode($zipCode); };
        if (isset($location)) { $property->setLocation($location); };

        $this->propertyRepository->update($property);
    }
}


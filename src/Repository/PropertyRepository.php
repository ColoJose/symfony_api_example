<?php

namespace App\Repository;

use App\Entity\Flat;
use App\Entity\House;
use App\Entity\Property;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends AbstractRepository
{

    private $validator;

    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Property::class);
        $this->validator = $validator;
    }

    public function update(Property $property, $data_decode )
    {
        /**
         * @var string $street
         * @var float $sqm
         * @var string $location
         * @var int $number
         * @var int $zipCode
         */
        extract($data_decode);
        if (isset($street)) { $property->setStreet($street); };
        if (isset($sqm)) { $property->setSqm($sqm); };
        if (isset($number)) { $property->setNumber($number); };
        if (isset($zipCode)) { $property->setZipCode($zipCode); };

        $this->insert($property);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(string $propertyType, $data): ?ConstraintViolationList {
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
            $this->insert($property);
            return null;
        }
    }

    /**
     * @param $data
     * @return Flat
     */
    private function createFlat($data) {
        $house = new Flat();
        $this->setCommonProperties($house, $data);
        $house->setIsLoft($data['isLoft']);
        $house->setAcceptPets($data['acceptPets']);

        return $house;
    }

    /**
     * @param $data
     * @return House
     */
    private function createHouse($data) {
        $house = new House();
        $this->setCommonProperties($house, $data);
        $house->setFloors($data['floors']);
        $house->setHasGarden($data['hasGarden']);
        if ($data['hasGarden']) {
            $house->setGardenSqm($data['gardenSqm']);
        }

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
}
